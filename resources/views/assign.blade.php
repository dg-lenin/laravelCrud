@extends('layouts.AdminLTE.index')

@section('icon_page', 'user')

@section('title', 'Assign Teacher')

@section('content')


<div class="container">
    {{-- <h1>Laravel 8 Crud with Ajax</h1> --}}
    <a class="btn btn-success" href="javascript:void(0)" id="createNewTeacher" style="margin-bottom: 10px"> Assign Teacher</a>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>Teacher Name</th>
                <th>Studend Name</th>
                <th width="300px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $teacher)
            <tr>
                <td>{{$teacher['teacher_name']}}</td>
                <td>{{$teacher['student_name']}}</td>
                <td>
                    {{-- <a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{$teacher['id']}}" data-original-title="Edit" class="edit btn btn-primary btn-sm editTeacher">Edit</a> --}}
                    <a href="{{ route('assignUserDelete', $teacher['id']) }}" data-toggle="tooltip"  data-id="{{$teacher['id']}}" data-original-title="Delete" class="btn btn-danger btn-sm deleteTeacher">Delete</a>
                </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
 

@endsection

@include('layouts.AdminLTE._includes._assign_teacher')

