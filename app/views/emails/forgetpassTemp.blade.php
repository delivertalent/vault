<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
     <div>
			Dear {{$userName}},<br/>
			Someone requested that the password be reset for the following account:<br/>
			User Email: {{ $userEmail }}<br/><br/>
			If this was a mistake, just ignore this email and nothing will happen.<br/>

			To reset your password, visit the following address::<br/>
			{{ $link }}<br/><br/>

			Thank you..     		
     </div>
    </body>
</html>