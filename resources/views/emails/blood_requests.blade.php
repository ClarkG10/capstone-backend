<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
</head>

<body>
    <h1>Blood Request Details</h1>
    <p>Requested By<br> <strong> {{ $receiverName }} </strong> </p>
    <p>Blood Type<br> <strong> {{ $bloodRequest->blood_type }} </strong> </p>
    <p>Component<br> <strong> {{ $bloodRequest->component }} </strong> </p>
    <p>Urgency Scale<br><strong> {{ $bloodRequest->urgency_scale }} </strong> </p>
    <p>Quantity<br> <strong> {{ $bloodRequest->quantity }} </strong> </p>
</body>

</html>