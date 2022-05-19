<template>
  <div class="row d-flex justify-content-center container">
    <div class="col-md-8">
      <div class="card-hover-shadow-2x mb-2 mt-2 card">
        <div class="card-header-tab card-header">
          <div class="card-header-title font-size-lg text-capitalize font-weight-normal"><i
              class="fa fa-tasks"></i>&nbsp;{{trans.ToDoList}}</div>

        </div>
        <div class="scroll-area-sm">
          <div class="alert d-none" style="margin: 15px;" role="alert"></div>
          <div class="ps-show-limits">
            <div style="position: static;" class="ps ps--active-y">
              <div class="ps-content">
                <ul class=" list-group list-group-flush">
                  <li class="list-group-item" v-for="(task, index) in data" :key="index">
                    <div v-if="task.priority == 'Low'" class="todo-indicator bg-success"></div>
                    <div v-else-if="task.priority == 'Middle'" class="todo-indicator bg-warning"></div>
                    <div v-else class="todo-indicator bg-danger"></div>
                    <div class="widget-content p-0">
                      <div class="widget-content-wrapper">
                        <div class="widget-content-left mr-2">
                          <label>{{index+1}}.&nbsp;</label>
                        </div>
                        <div class="widget-content-left">
                          <div class="widget-heading">{{task.name}}
                          </div>
                          <div class="widget-subheading"><i>{{task.priority}}</i></div>
                        </div>
                      <div class="widget-content-right">
                        <button class="border-0 btn-transition btn btn-outline-success" v-on:click="callEditTask(task.id)">
                          <i class="fa fa-pencil"></i></button>
                        <button class="border-0 btn-transition btn btn-outline-danger" v-on:click="callDeleteTask(task.id)">
                          <i class="fa fa-trash"></i>
                        </button>
                      </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              
            </div>
          </div>
        </div>
        <div class="d-block text-right card-footer">
          <button class="btn btn-primary"  v-on:click="callAddTask()">{{trans.AddTask}}</button></div>
      </div>
    </div>
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{trans.AddNew}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                      <label for="name">{{trans.TaskName}}</label>
                      <input type="text" class="form-control" id="name" v-model="task.name" :placeholder="trans.EnterTaskName">
                    </div>
                    <div class="form-group">
                      <label for="inputState">{{trans.Priority}}</label>
                      <select id="inputState" v-model="task.priority" class="form-control">
                        <option value="" selected>Choose...</option>
                        <option value="Low">Low</option>
                        <option value="Middle">Middle</option>
                        <option value="High">High</option>
                      </select>
                    </div>

                    <div class="alert d-none" role="alert">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                        data-dismiss="modal">{{trans.Cancel}}</button>
                    <button type="button" v-on:click="postTask()" class="btn btn-primary">{{trans.Add}}</button>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{trans.EditTask}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                      <label for="name">{{trans.TaskName}}</label>
                      <input type="text" class="form-control" id="name" v-model="taskEdit.name" :placeholder="trans.EnterTaskName">
                    </div>
                    <div class="form-group">
                      <label for="inputState">{{trans.Priority}}</label>
                      <select id="inputState" v-model="taskEdit.priority" class="form-control">
                        <option value="" selected>Choose...</option>
                        <option value="Low">Low</option>
                        <option value="Middle">Middle</option>
                        <option value="High">High</option>
                      </select>
                    </div>

                    <div class="alert d-none" role="alert">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                        data-dismiss="modal">{{trans.Cancel}}</button>
                    <button type="button" v-on:click="editTask()" class="btn btn-primary">{{trans.Edit}}</button>

                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
    export default {
      props: ['trans'],
      data: function() {
        return {
          data: [],
          task: {
            name: '',
            priority: ''
          },
          taskEdit: {
            name: '',
            priority: ''
          },
          id: ''
        }
      },
      mounted() {
        var app = this
        console.log('Component mounted.')
        axios.get('/api/task/list')
          .then(function (resp) {
              app.data = resp.data.data
          })
          .catch(function (error) {
            console.log(error)
          });
      },
      methods: {
        callAddTask: function() {
          $('#addModal').modal('show')
        },
        postTask: function() {
          var app = this

          var createTask = app.task

          $(".alert").addClass('d-none')
          $(".alert").removeClass('alert-danger')
          $(".alert").removeClass('alert-success')

          if(app.task.name == ''){
            $(".alert").removeClass('d-none');
            $(".alert").removeClass('alert-success');
            $(".alert").addClass('alert-danger');
            $(".alert").html(app.trans.TaskName+app.trans.Required);
          }else if(app.task.priority == ''){
            $(".alert").removeClass('d-none');
            $(".alert").removeClass('alert-success');
            $(".alert").addClass('alert-danger');
            $(".alert").html(app.trans.Priority+app.trans.Required);
          }else{
            axios.post('/api/task/create', createTask)
                .then(function (resp) {
                  if(resp.data.error === 0){
                    $(".alert").removeClass('d-none');
                    $(".alert").removeClass('alert-danger');
                    $(".alert").addClass('alert-success');
                    $(".alert").html(resp.data.message);
                    setTimeout(()=>{
                      location.reload()
                    }, 1500); 
                  }else{
                    $(".alert").removeClass('d-none');
                    $(".alert").addClass('alert-danger');
                    $(".alert").removeClass('alert-success');
                    $(".alert").html(resp.data.message);

                  }
                })
                .catch(function (error) {
                  $(".alert").removeClass('d-none');
                  $(".alert").addClass('alert-danger');
                  $(".alert").removeClass('alert-success');
                  $(".alert").html(error);
                  
                });
          }
        },
        callEditTask: function(id) {
          var app = this
          var getTask = app.data.find(o => o.id === id)
          console.log(getTask.name)
          app.id = id
          app.taskEdit.name = getTask.name
          app.taskEdit.priority = getTask.priority
          $('#editModal').modal('show')
        },
        editTask: function() {
          var app = this

          var editTask = app.taskEdit

          $(".alert").addClass('d-none')
          $(".alert").removeClass('alert-danger')
          $(".alert").removeClass('alert-success')

          if(app.taskEdit.name == ''){
            $(".alert").removeClass('d-none');
            $(".alert").removeClass('alert-success');
            $(".alert").addClass('alert-danger');
            $(".alert").html(app.trans.TaskName+app.trans.Required);
          }else if(app.taskEdit.priority == ''){
            $(".alert").removeClass('d-none');
            $(".alert").removeClass('alert-success');
            $(".alert").addClass('alert-danger');
            $(".alert").html(app.trans.Priority+app.trans.Required);
          }else{
            axios.put('/api/task/update/'+app.id, editTask)
                .then(function (resp) {
                  if(resp.data.error === 0){
                    $(".alert").removeClass('d-none');
                    $(".alert").removeClass('alert-danger');
                    $(".alert").addClass('alert-success');
                    $(".alert").html(resp.data.message);
                    setTimeout(()=>{
                      location.reload()
                    }, 1500); 
                  }else{
                    $(".alert").removeClass('d-none');
                    $(".alert").addClass('alert-danger');
                    $(".alert").removeClass('alert-success');
                    $(".alert").html(resp.data.message);

                  }
                })
                .catch(function (error) {
                  $(".alert").removeClass('d-none');
                  $(".alert").addClass('alert-danger');
                  $(".alert").removeClass('alert-success');
                  $(".alert").html(error);
                  
                });
          }
        },
        callDeleteTask: function(id) {
          var app = this
          axios.delete('/api/task/delete/'+id)
            .then(function (resp) {
              if(resp.data.error === 0){
                $(".alert").removeClass('d-none');
                $(".alert").removeClass('alert-danger');
                $(".alert").addClass('alert-success');
                $(".alert").html(resp.data.message);
                setTimeout(()=>{
                  location.reload()
                }, 1500); 
              }else{
                $(".alert").removeClass('d-none');
                $(".alert").addClass('alert-danger');
                $(".alert").removeClass('alert-success');
                $(".alert").html(resp.data.message);

              }
            })
            .catch(function (error) {
              $(".alert").removeClass('d-none');
              $(".alert").addClass('alert-danger');
              $(".alert").removeClass('alert-success');
              $(".alert").html(error);
              
            });
        }
      }
    }
</script>
