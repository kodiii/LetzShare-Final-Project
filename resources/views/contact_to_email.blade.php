@if($data['sendEmail'])

<p>Thank you {{ $data['fullname'] }} for your message!</p>
<h3>Your message:</h3>
<p>{{ $data['message'] }}</p>
<hr>
<p><small>Your IP address: {{ $data['ip'] }}</small></p>
<p><small>Date: {{ $data['timestamp'] }}</small></p>

@else

<p>You just received a message from
    <strong> {{ $data['fullname'] }}</strong>!
</p>
<p><i>"{{ $data['message'] }}"<i></p>
<hr>
<p>Email: {{ $data['from'] }} </p>
<p><small>Date: {{ $data['timestamp'] }}</small></p>

@endif
