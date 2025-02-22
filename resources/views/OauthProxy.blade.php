<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing OAuth...</title>
    <script>
        (function () {
           
            if (window.location.hash.includes('access_token')) {

                let hash = window.location.hash.substring(1);
                let queryParams = new URLSearchParams(hash);
                
              
                let accessToken = queryParams.get('access_token');
                let refreshToken = queryParams.get('refresh_token');

             
                window.location.href = `/auth/supabase/callback?access_token=${accessToken}&refresh_token=${refreshToken}`;
            }
        })();
    </script>
</head>
<body>
    <p>Processing login...</p>
</body>
</html>
