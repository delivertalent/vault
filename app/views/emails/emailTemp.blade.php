<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
     <div>
			Dear {{$userName}},<br/>
			Welcome to vault@ncbeta.net Please find your sign in credentials below:<br/>
			Email: {{ $userEmail }}<br/>
			Password: {{ $userPassword }}<br/>
			You can login below and change your password:<br/>
			{{ $link }}<br/>
			Please save this email for future reference.<br/><br/>

			Thank you..     		
     </div>
    </body>
</html>