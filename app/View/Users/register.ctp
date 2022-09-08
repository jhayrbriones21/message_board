<form id="registration_form">
  <div class="form-group">
    <label>Name</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
  </div>
  <div class="form-group">
    <label>Email address</label>
    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
  </div>
  <div class="form-group">
    <label>Password</label>
    <input type="password" class="form-control" id="password" name="password"placeholder="Enter password">
  </div>

  <div class="form-group">
    <label>Confirm Password</label>
    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Enter confirm password">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script type="text/javascript">
    $("form").on("submit", function(event){
        event.preventDefault();

        var form_data = new FormData($(this)[0]);

        $.ajax({
            url: 'register',
            type: 'post',
            data: form_data,
            processData: false,
            contentType: false,
            // dataType: "json",
            success: function(data, textStatus, jqXHR) {
               // location.assign("success");
            },
            error: function(data, textStatus, jqXHR) {
               //process error msg
               console.log(data);
            },
        })
    });
</script>