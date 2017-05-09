@foreach($organization as $organization)
{{$organization['organization_name']}}
{{$organization->User()}}


@endforeach