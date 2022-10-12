const cron = require('node-cron');
const moment = require('moment')
const fs = require('fs')
const simpleGit = require('simple-git')();
const shellJs = require('shelljs');
const simpleGitPromise = require('simple-git/promise')();
const spawn = require('child_process').spawn

// You can adjust the backup frequency as you like, this case will run once a day
cron.schedule('*/1 * * * *', () => {
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
      const repo = 'message_board';

      const userName = 'jhayrbriones21';
      const password = 'iowdlac12';

      const gitHubUrl = `https://${userName}:${password}@github.com/${userName}/${repo}`;
      simpleGit.addConfig('user.email','fdc.jhayr@gmail.com');
      simpleGit.addConfig('user.name','Jhayr Briones');

      // simpleGitPromise.addRemote('origin',gitHubUrl);
	// Add all files for commit
	  simpleGitPromise.add('.')
	    .then(
	       (addSuccess) => {
	          console.log(addSuccess);
	       }, (failedAdd) => {
	          console.log('adding files failed');
	    });
	// Commit files as Initial Commit
	 simpleGitPromise.commit(`DB backup ${fileName}`)
	   .then(
	      (successCommit) => {
	        console.log(successCommit);
	     }, (failed) => {
	        console.log('failed commmit');
	 });
	// Finally push to online repository
	 simpleGitPromise.push('origin','master')
	    .then((success) => {
	       console.log('repo successfully pushed');
	    },(failed)=> {
	       console.log('repo push failed');
	 });

    })
    .on('error', (err) => {
      console.log(err)
    })
})