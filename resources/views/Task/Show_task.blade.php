@extends('Temp')
@section('cont')
<div class="content">
    <nav class="mb-2" aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('task.all')}}">List Task</a></li>
        <li class="breadcrumb-item active">Task details</li>
      </ol>
    </nav>


    <div class="pb-9">
      <div class="row align-items-center justify-content-between g-3 mb-4">

        <div class="col-12 col-md-auto">
          <h2 class="mb-0">Task details</h2>
        </div>

        <div class="col-12 col-md-auto d-flex">
            <a href="{{route('task.edit',['id'=>$data->id,'redirect_to'=>'1'])}}" class="btn btn-phoenix-secondary px-3 px-sm-5 me-2">
                 <span class="fa-solid fa-edit me-sm-2"></span> 
                 <span class="d-none d-sm-inline">Edit		
                    </span>
                </a>
                <form method="POST" action="{{route('task.delete',['id'=>$data->id])}}" >
                  @csrf
                <button class="btn btn-phoenix-danger me-2">
                     <span class="fa-solid fa-trash me-2"></span><span>Delete Task</span>
                </button>
              </form>
        </div>
      </div>

      <div class="row g-4 g-xl-6">
        <div class="col-xl-5 col-xxl-4">
          <div class="sticky-leads-sidebar">
            <div class="card mb-3">
              <div class="card-body">
                <div class="row align-items-center g-3">
                  <div class="col-12 col-sm-auto flex-1">
                    <h3 class="fw-bolder mb-2 line-clamp-1">{{$data->name}}</h3>
                    <div class="d-md-flex d-xl-block align-items-center justify-content-between mb-5">
                      <div class="d-flex align-items-center mb-3 mb-md-0 mb-xl-3">
                        @if ($data->emp_id)
                        <div class="avatar avatar-xl me-3">
                            <img class="rounded-circle" src="{{(!is_null($data->employee->image))?asset("storage/".$data->employee->image):asset("storage/logos/inconnue.jpeg")}}" alt="">
                        </div>
                        <div>
                          <h5>{{$data->employee->firstName.' '.$data->employee->lastName}}</h5>
                        </div>
                        @else
                        <h5>none</h5>
                        @endif
                      </div>
                      <div>
                        @if ($data->etat=='new')
                        <span class="badge badge-phoenix fs--2 badge-phoenix-primary">new</span>
                        @else
                          @if ($data->etat=='completed')
                            <span class="badge badge-phoenix fs--2 badge-phoenix-success">completed</span>
                            @else
                                @if ($data->etat=='pending')
                                <span class="badge badge-phoenix fs--2 badge-phoenix-info">ON Pending</span>
                                @else
                                <span class="badge badge-phoenix fs--2  badge-phoenix-secondary">Cancelled</span>
                                @endif
                             @endif
                        @endif
                        @if ($data->prio==0)
                        <span class="badge badge-phoenix fs--2 mb-4 badge-phoenix-secondary">little</span>
                        @else
                          @if ($data->prio==1)
                          <span class="badge badge-phoenix fs--2 mb-4 badge-phoenix-warning">medium</span>
                            @else
                            @if ($data->prio==2)
                            <span class="badge badge-phoenix fs--2 mb-4 badge-phoenix-danger">Urgent</span>
                             @endif
                                @endif
                        @endif
                    </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>

            <div class="card">
              <div class="card-body">
                <h4 class="mb-5">Others Information</h4>
                <div class="row g-3">
                  <div class="col-12">
                    <div class="mb-4">
                        <h5 class="mb-0 text-1000 mb-2">Owner</h5>
                            <div class="avatar avatar-xl me-3">
                                <img class="rounded-circle" src="{{(!is_null($data->manager->image))?asset("storage/".$data->manager->image):asset("storage/logos/inconnue.jpeg")}}" alt="">
                            </div>
                            <div>
                              <h6>{{$data->manager->firstName.' '.$data->manager->lastName}}</h6>
                            </div>
                          </div>
                    </div>
                    <div class="mb-4">
                        <h5 class="mb-0 text-1000 mb-2">Project Name:</h5>
                      <p>
                        {{$data->project->nom}}
                      </p>
                    </div>
                    <div class="mb-4">
                        <h5 class="mb-0 text-1000 mb-2">description</h5>
                      <p>
                        {{$data->desc}}
                      </p>
                    </div>
                    <div class="mb-4">
                        <h5 class="mb-0 text-1000 mb-2">Started </h5>
                      <p>
                        {{$data->date_deb}}
                      </p>
                    </div>
                    <div class="mb-4">
                        <h5 class="mb-0 text-1000 mb-2">Deadline  </h5>
                      <p>
                        {{$data->date_deb}}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        <div class="col-xl-7 col-xxl-8" style="  overflow-y: scroll; height: 53rem;">
          <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade active show" id="tab-notes" role="tabpanel" aria-labelledby="notes-tab">
              <h2 class="mb-4">Notes</h2>
              <textarea id="message_send" class="form-control mb-3" id="notes" rows="4"> </textarea>
              <button type="button" onclick="add_com()"  class="btn btn-phoenix-info">add feedback</button></div>
                <div id="content_feed">

            </div>
            </div>
            </div>
            @if (auth()->user()->role=='admin')
            
            <div class="accordion" id="accordionExample">
              <div class="accordion-item border-top border-300">
                <h2 class="accordion-header" id="headingOne">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    History
                  </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseOne" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                  @if (count($his))
                  <table class="table fs--1 mb-0 border-top border-200">
                    <thead>
                      <tr>
                        <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="projectName" style="width:30%;">Action</th>
                        <th class="sort align-middle ps-3" scope="col" data-sort="assigness" style="width:10%;">User</th>
                        <th class="sort align-middle ps-3" scope="col" data-sort="deadline" style="width:15%;">Date</th>
                        <th class="sort align-middle ps-3" scope="col" data-sort="deadline" style="width:15%;">Time</th>
              
                      </tr>
                    </thead>
                    <tbody class="list" id="project-list-table-body">
                      @foreach ($his as $item)
                      <tr class="position-static">
                      <td class="align-middle white-space-nowrap task ps-3 py-4">
                        @if ($item['Action']=='created')
                        <span class="badge badge-phoenix fs--2 badge-phoenix-success">created</span>
                        @else
                            @if ($item['Action']=='updated')
                            <span class="badge badge-phoenix fs--2 badge-phoenix-primary">updated</span>
                            @else
                                @if ($item['Action']=='deleted')
                                <span class="badge badge-phoenix fs--2 badge-phoenix-warning">deleted</span>
                                @else
                                <span class="badge badge-phoenix fs--2  badge-phoenix-secondary">restored</span>
                                @endif
                            @endif
                        @endif
                      </td>
                      <td class="align-middle white-space-nowrap task ps-3 py-4">
                        <div class="avatar-group avatar-group-dense">
                          <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="{{route('user.show',['id'=>$item['User']['id']])}}" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                            <div class="avatar avatar-s  rounded-circle">
                              <img class="rounded-circle "
                              title="{{$item['User']['name']}}"
                              src="{{(!is_null($item['User']['image']))?asset("storage/".$item['User']['image']):asset("storage/logos/inconnue.jpeg")}}" alt="">
                            </div>
                          </a>
                        </div>
                      </td>
                      <td class="align-middle white-space-nowrap task ps-3 py-4">
                        <p class="fw-bo text-900 fs--1 mb-0">{{$item['Date']}}</p>
                      </td>
                      <td class="align-middle white-space-nowrap task ps-3 py-4">
                        <p class="fw-bo text-900 fs--1 mb-0">{{$item['Time']}}</p>
                      </td></tr>
                      @endforeach
                        </tbody>
                  </table>
                  @else
                  <div class="accordion-body pt-0">
                    <strong>No History</strong>
                  </div>
                  @endif
                  
                </div>
              </div>
            </div>
          
            @endif
        </div>
      </div>
    </div>
    
  </div>
  <script>  
      function checkIfEmpty(value) {
  if (value.trim().length === 0) {
    return true; // Value is empty
  } else {
    return false; // Value is not empty
  }
}
      const add_com=()=>{
        const a=document.getElementById('message_send').value        
        if(!checkIfEmpty(a)){
            axios.post("{{route('feedback.add')}}",
            {
            message:a,
            _token:'{{ csrf_token() }}',
            tag_id:{{$data->id}},
            }).then(res=>alert(res.data))
        }else{
            console.log('empty');
        }
       
    }
    window.onload = function() {
      setTimeout(combine(), 1000)
};
  function combine(){
    action();
    setInterval(() => {
      action();
    }, 2000);
  }
  var myArray = [];
function action() {
  getFeedback()
    .then(data => {
      if (data.length > 0) {
        data.forEach(feedback => {
          if (!myArray.includes(feedback['id_feed'])) {
            const timestamp = feedback['date'];
            const [datePart, timePart] = timestamp.split('T');
            const feedbackData = {
              feedback: feedback['feedback'],
              date: datePart,
              author: feedback['author'],
              email: feedback['email']
            };
            createFeedbackElement(feedbackData);
            myArray.push(feedback['id_feed']);
          }
        });
      }
    })
    .catch(error => {
      console.log('Error:', error);
    });
  }

    function getFeedback(){
      return axios.get("{{ route('feedback') }}", {
      params: {
        id_tag: {{$data->id}},
        _token: '{{ csrf_token() }}'
      }
    })
    .then(response => {
      return response.data;
    })
    .catch(error => {
      console.log('Error:', error);
      return null;
    });
    }
    function createFeedbackElement(feedbackData) {
  const contentFeedDiv = document.getElementById('content_feed');

  // Create the main elements
  const rowDiv = document.createElement('div');
  rowDiv.classList.add('row', 'gy-4');

  const colDiv = document.createElement('div');
  colDiv.classList.add('col-12', 'col-xl-auto', 'flex-1');

  const borderDiv = document.createElement('div');
  borderDiv.classList.add('border-2', 'border-dashed', 'mb-4', 'pb-4', 'border-bottom');

  // Create the paragraph element for feedback
  const feedbackPara = document.createElement('p');
  feedbackPara.classList.add('mb-1', 'text-1000');
  feedbackPara.textContent = feedbackData.feedback;

  // Create the div for the date and author
  const divDateAuthor = document.createElement('div');
  divDateAuthor.classList.add('d-flex');

  // Create the span for the clock icon and date
  const spanClock = document.createElement('span');
  spanClock.classList.add('fa-solid', 'fa-clock', 'me-2');
  spanClock.textContent = 'clock';

  const spanDate = document.createElement('span');
  spanDate.classList.add('fw-semi-bold', 'me-1');
  spanDate.textContent = feedbackData.date;

  // Create the paragraph for the author
  const authorPara = document.createElement('p');
  authorPara.classList.add('fs--1', 'mb-0', 'text-600');
  authorPara.textContent = 'by ';

  const authorLink = document.createElement('a');
  authorLink.classList.add('ms-1', 'fw-semi-bold');
  authorLink.href = `mailto: ${feedbackData.email}`;
  authorLink.textContent = feedbackData.author;

  // Assemble the elements
  divDateAuthor.appendChild(spanClock);
  divDateAuthor.appendChild(spanDate);

  authorPara.appendChild(divDateAuthor);
  authorPara.appendChild(authorLink);

  borderDiv.appendChild(feedbackPara);
  borderDiv.appendChild(authorPara);

  colDiv.appendChild(borderDiv);
  rowDiv.appendChild(colDiv);

  contentFeedDiv.appendChild(rowDiv);
}
  </script>
@endsection