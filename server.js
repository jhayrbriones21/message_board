const cron = require('node-cron');
const moment = require('moment')
const fs = require('fs')
const simpleGit = require('simple-git')();
const shellJs = require('shelljs');
const simpleGitPromise = require('simple-git/promise')();
const spawn = require('child_process').spawn

// You can adjust the backup frequency as you like, this case will run once a day
cron.schedule('*/5 * * * *', () => {
// Use moment.js or any other way to dynamically generate file name
  const fileName = `test_${moment().format('YYYY_MM_DD_h_mm_ss')}.sql`
  const wstream = fs.createWriteStream(`/Applications/XAMPP/htdocs/test/${fileName}`)
  console.log('---------------------')
  console.log('Running Database Backup Cron Job')
  const mysqldump = spawn('/Applications/XAMPP/bin/mysqldump', [ '--opt', '--host=localhost', '-u', 'root', `--password=`, 'testdb' ])

  mysqldump
    .stdout
    .pipe(wstream)
    .on('finish', () => {
      console.log('DB Backup Completed!')

      shellJs.cd('/Applications/XAMPP/htdocs/test');

      simpleGit.add(fileName)
			   .commit(fileName)
			   .push(['-u', 'origin', 'master'], () => {
			   		console.log('push successfully');
			   });

    })
    .on('error', (err) => {
      console.log(err)
    })
});