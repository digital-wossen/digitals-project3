@extends('layouts.app')

@section('content')



     <div class="ol-md-9 col-lg-9 col-sm-9 pull-left ">
      <!-- The justified navigation menu is meant for single line per list item.
           Multiple lines will require custom code not provided by Bootstrap. -->
      <!-- Jumbotron -->
      <div class="well well-lg" >

        <h1>{{ $task->name }}</h1>
  
        <p class="lead">{{ $task->description }}</p>
       <!-- <p><a class="btn btn-lg btn-success" href="#" role="button">Get started today</a></p> -->
      </div>

      <!-- Example row of columns -->
      <div class="col-md-12 col-lg-12 col-sm-12" style="background: white; margin: 10px; ">
     <!-- <a href="/digitals-project3/public/tasks/create" class="pull-right btn btn-default btn-sm" >Add Task</a> -->
<br/>

@include('partials.comments')


<div class=" container-fluid">

<form method="post" action="{{ route('comments.store') }}">
                            {{ csrf_field() }}


                            <input type="hidden" name="commentable_type" value="App\Task">
                            <input type="hidden" name="commentable_id" value="{{$task->id}}">


                            <div class="form-group">
                                <label for="comment-content">Comment</label>
                                <textarea placeholder="Enter comment"
                                          style="resize: vertical"
                                          id="comment-content"
                                          name="body"
                                          rows="3" spellcheck="false"
                                          class="form-control autosize-target text-left">


                                          </textarea>
                            </div>


                            <div class="form-group">
                                <label for="comment-content">Proof of work done (Url)</label>
                                <textarea placeholder="Enter url or screenshots"
                                          style="resize: vertical"
                                          id="comment-content"
                                          name="url"
                                          rows="5" spellcheck="false"
                                          class="form-control autosize-target text-left">


                                          </textarea>
                            </div>


                            <div class="form-group">
                                <input type="submit" class="btn btn-primary"
                                       value="Submit"/>
                            </div>
                        </form>



                        </div>



      </div>
</div>


<div class="col-sm-3 col-md-3 col-lg-3 pull-right">
          <!--<div class="sidebar-module sidebar-module-inset">
            <h4>About</h4>
            <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
          </div> -->
          <div class="sidebar-module">
            <h4>Actions</h4>
            <ol class="list-unstyled">
              <li><a href="/digitals-project3/public/tasks/{{ $task->id }}/edit">
              <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
              Edit</a></li>
              <li><a href="/digitals-project3/public/tasks/create"><i class="fa fa-plus-circle" aria-hidden="true"></i> Create new Task</a></li>
              <li><a href="/digitals-project3/public/tasks"><i class="fa fa-user-o" aria-hidden="true"></i> My Tasks</a></li>

            <br/>


            @if($task->user_id == Auth::user()->id)

              <li>
              <i class="fa fa-power-off" aria-hidden="true"></i>
              <a
              href="#"
                  onclick="
                  var result = confirm('Are you sure you wish to delete this task?');
                      if( result ){
                              event.preventDefault();
                              document.getElementById('delete-form').submit();
                      }
                          "
                          >
                  Delete
              </a>

              <form id="delete-form" action="{{ route('tasks.destroy',[$task->id]) }}"
                method="POST" style="display: none;">
                        <input type="hidden" name="_method" value="delete">
                        {{ csrf_field() }}
              </form>

              </li>
 @endif
              <!-- <li><a href="#">Add new member</a></li> -->
            </ol>
<hr/>

            <h4>Add members</h4>
            <div class="row">
              <div class="col-lg-12 col-md-12 col-xs-12  col-sm-12 ">
              <form id="add-user" action="{{ route('tasks.adduser') }}"  method="POST" >
                {{ csrf_field() }}
                <div class="input-group">
                  <input class="form-control" name = "task_id" id="task_id" value="{{ $task->id}}" type="hidden">
                  <input type="text" required class="form-control" id="email"  name = "email" placeholder="Email">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="submit" id="addMember" >Add!</button>
                  </span>
                </div><!-- /input-group -->
                </form>
              </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
<br/>
            <h4>Team Members</h4>
            <ol class="list-unstyled" id="member-list">
            @foreach($task->users as $user)
              <li><a href="#"> {{$user->email}} </a> </li>

              @endforeach
            </ol>

          </div>

          <!--<div class="sidebar-module">
            <h4>Members</h4>
            <ol class="list-unstyled">
              <li><a href="#">March 2014</a></li>
            </ol>
          </div> -->
        </div>


    @endsection

    @section('jqueryScript')
                      <script type="text/javascript">

                            $('#addMember').on('click',function(e){
                              e.preventDefault(); //prevent the form from auto submit

                            //   $.ajaxSetup({
                            //     headers: {
                            //         'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            //     }
                            // });


                            var formData = {
                              'task_id' : $('#task_id').val(),
                              'email' : $('#email').val(),
                              '_token': $('input[name=_token]').val(),
                            }

                            var url = 'tasks/adduser';

                            $.ajax({
                              type: 'post',
                              url: "{{ URL::route('tasks.adduser') }}",
                              data : formData,
                              dataType : 'json',
                              success : function(data){

                                    var emailField = $('#email').val();

                                  $('#member-list').prepend('<li><a href="#">'+ emailField +'</a> </li>');
                                  $('#email').val('');
                              },
                              error: function(data){
                                //do something with data
                                console.log("error sending ajax request" + data);
                              }
                            });


                            });

                      </script>


@endsection







