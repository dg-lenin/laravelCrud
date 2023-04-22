@extends('layouts.AdminLTE.index')

@section('icon_page', 'user')

@section('title', 'Teacher')

@section('content')


<div class="container">
    {{-- <h1>Laravel 8 Crud with Ajax</h1> --}}
    <a class="btn btn-success" href="javascript:void(0)" id="createNewTeacher" style="margin-bottom: 10px"> Create New Teacher</a>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th width="300px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
 

@endsection

@include('layouts.AdminLTE._includes._teacher')

