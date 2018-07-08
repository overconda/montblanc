<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  </head>
  <body>
    <form>
      <input type="hidden" name="fbId">
      <input type="hidden" name="fbName">
      <input type="hidden" name="fbAvatar">
    </form>
  </body>

  <script>
  // This is called with the results from from FB.getLoginStatus().
    function statusChangeCallback(response) {
      console.log('statusChangeCallback');
      console.log(response);
      if (response.status === 'connected') {
        // Logged into your app and Facebook.
        testAPI();
      } else {
        // The person is not logged into your app or we are unable to tell.
        // document.getElementById('status').innerHTML = 'Please log into this app.';
      }
    }

    function checkLoginState() {
      console.log('checkLoginState');
      FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
      });
    }

    window.fbAsyncInit = function() {
    FB.init({
      appId      : '1940665059558112',
      cookie     : true,  // enable cookies to allow the server to access
                          // the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v2.8' // use graph api version 2.8
    });

    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });

    };

    // Load the SDK asynchronously
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    // Here we run a very simple test of the Graph API after login is
    // successful.  See statusChangeCallback() for when this call is made.
    function testAPI() {
      var userid;
      FB.api('/me', function(response) {
        var id = response.id;
        var name = response.name;
        var avatar_url = 'https://graph.facebook.com/' + response.id + '/picture?width=140&height=140';

        /// check fbId with database , if not found , create the new one
        $('input[name="fbId"]').val(response.id);
        $('input[name="fbName"]').val(name);
        $('input[name="fbAvatar"]').val(avatar_url);
        var formData = new FormData(document.getElementById('myForm'));

        $.ajax({
          type: 'post',
          url: '_save_profile.php',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          success: function(answ){
              //silent
              console.log('ajax success: ' +  answ);
              //console.log(answ['userid']);
              userid = answ;
              if(window.localStorage){
                localStorage.setItem("userid", userid);

                localStorage.setItem("fbId", id);
                localStorage.setItem("fbName", name);
                localStorage.setItem("fbAvatar", avatar_url);

                window.location = "step2.html";
              }else{
                alert('Can not save localStorage');
              }

          },
          error: function(answ){
             //silent
            console.log('ajax error: ' + answ);
          },
      })




      });
    }
  </script>

</html>
