@section('layout_css')

<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

@endsection

@section('layout_js')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
	$(function () {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
	  });
	  var table = $('.data-table').DataTable({
		  processing: true,
		  serverSide: false
	  });
	  $('#createNewTeacher').click(function () {
		
		  $('#saveBtn').val("create-teacher");
		  $('#teacher_id').val('');
		  $('#teacherForm').trigger("reset");
		  $('#modelHeading').html("Create New Teacher");
		  $('#ajaxModel').modal('show');
		  $('#ajaxModel').addClass('in show');
		//   $('#ajaxModel').css('display:block, color:red');
	  });
	  $('body').on('click', '.editTeacher', function () {
		var teacher_id = $(this).data('id');
		$.get("{{ route('teachers.index') }}" +'/' + teacher_id +'/edit', function (data) {
			$('#modelHeading').html("Edit Teacher");
			$('#saveBtn').val("edit-teacher");
			$('#ajaxModel').modal('show');
			$('#ajaxModel').addClass('in show');
			$('#teacher_id').val(data.id);
			$('#first_name').val(data.first_name);
			$('#last_name').val(data.last_name);
			$('#email').val(data.email);
		})
	 });
	//   $('#teacherForm').submit(function (e) {alert(4);
	// 	e.preventDefault();alert(5);
	//   });

	  $('#saveBtn').click(function (e) {
		  e.preventDefault();
		  $(this).html('Save');
		  
		  var teacher_id = $('#teacherId').val();
		  var student_id = $('#studentId').val();
		
		  if(teacher_id==0 || student_id ==0){
			$('#err_text').html("Please select all fields");
		  }
		  else{
		  $.ajax({
			data: $('#teacherForm').serialize(),
			url: "{{ route('assignUser') }}",
			type: "POST",
			dataType: 'json',
			success: function (data) {
				if(data.error){
					$('#err_text').html(data.error);
				}else{
					$('#err_text').html(data.success);
					location.reload();
				}
			},
			error: function (data) {
				console.log('Error:', data);
				$('#saveBtn').html('Save');
			}
		});
		}
	  });
	  $('body').on('click', '.deleteTeacher', function () {
	   
		  var teacher_id = $(this).data("id");
		  confirm("Are You sure want to delete !");
		
		  $.ajax({
			  type: "get",
			  url: "{{ route('assignUserDelete') }}"+'/'+teacher_id,
			  success: function (data) {
				  table.draw();
				  location.reload();
			  },
			  error: function (data) {
				  console.log('Error:', data);
			  }
		  });
	  });
	   
	});
  </script>
	@yield('in_data_table')
@endsection

<div class="modal fade" id="ajaxModel">
    <div class="modal-dialog">
        <div class="modal-content"  style="padding: 25px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Assign Teacher</h4>
            </div>
            <div class="modal-body">
                <form id="teacherForm" name="teacherForm" class="form-horizontal">
                    <input type="hidden" name="teacher_id" id="teacher_id">
                     <div class="form-group">
                         <label for="teacherId" class="col-sm-4">Select Teacher<span class="text-danger">*</span></label>
                         <div class="col-sm-12">
							 <select class="form-control" id="teacherId" name="teacherId">
								<option value='0' selected>Select</option>
								@foreach($teachers as $teacher)
								<option value="{{$teacher->id}}">{{$teacher->first_name.' '.$teacher->last_name}}</option>
								@endforeach
							 </select>
                         </div>
                     </div>
                     <div class="form-group">
						<label for="studentId" class="col-sm-4">Select Student<span class="text-danger">*</span></label>
						<div class="col-sm-12">
							<select class="form-control" id="studentId" name="studentId">
								<option value='0' selected>Select</option>
							   @foreach($students as $student)
							   <option value="{{$student->id}}">{{$student->first_name.' '.$student->last_name}}</option>
							   @endforeach
							</select>
						</div>
					</div>
					 <div><span class="text-danger" id="err_text">&nbsp;</span></div>
                     <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save
                      </button>
                     </div>
                 </form>
            </div>
            
        </div>
    </div>
</div>