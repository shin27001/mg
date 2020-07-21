@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <a href="/mypage/create?id=">新規作成</a>
            <div class="table-resopnsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{__('ID')}}</th>
                            <th>{{__('nickname')}}</th>
                            <th>{{__('name')}}</th>
                            <th>{{__('mail')}}</th>
                            <th>{{__('address')}}</th>
                            <th>{{__('tel_no')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($users))
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->profile->nickname }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email}}</td>
                                    <td>{{ $user->profile->address }}</td>
                                    <td>{{ $user->profile->tel_no }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection