<h1>hello {{$user->first_name}}</h1>
<p>you can reset you password from this link</p>

<p><a href="{{ env('APP_URL','http://localhost:8000'.'/reset/'.$user->email.'/'.$token)}}">click here</a></p>
