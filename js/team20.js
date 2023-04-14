  function signOut() {
    gapi.auth2.getAuthInstance().signOut().then(function () {
        console.log('user signed out');    
    window.setTimeout(function() {
        window.location.href =
          "https://cgi.luddy.indiana.edu/~jcarlsso/capstone-team/logout.php";
      }, 100);
    })
  }
