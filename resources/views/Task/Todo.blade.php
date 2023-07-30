@extends('Temp')
@section('cont')
@php
    $j=0;
@endphp
<div class="content" >
    <div class="mb-9">
      <h2 class="mb-4">Todo list<span class="text-700 fw-normal">({{$data['all']}})</span></h2>
      <div class="row align-items-center g-3 mb-3">
        <div class="col-sm-auto">
          <div class="search-box">

            <form class="position-relative" data-bs-toggle="search" data-bs-display="static" action="{{route('todo')}}">
                @csrf
                <div  class="input-group">
                    <input 
                    value="{{$data['search']}}"
                    class="form-control search-input search" 
                    type="search" placeholder="Search tasks" 
                    aria-label="Search"
                    name="search"
                    >
                    <div class="input-group-append">
                      <button  style="border: none;" class="btn"  type="submit">
                        <span style="font-size: 200%" class="fas fa-search search-box-icon"></span>
                      </button>
                </div>
          </div>
        </div>
        
      </div>
      <div class="mb-4 todo-list">
        @if(count($data['data'])>0)
        @foreach ($data['data'] as $item)
        @php
            ++$j;
        @endphp
        <div 
        class="row justify-content-between align-items-md-center hover-actions-trigger btn-reveal-trigger border-200 py-3 gx-0 cursor-pointer border-top" 
        onclick="loadFeedback({{$item->id}},'content{{$j}}')" 
        id="taskelement{{$j}}" 
        data-todo-offcanvas-toogle="data-todo-offcanvas-toogle" 
        data-todo-offcanvas-target="todoOffcanvas-{{$j}}">
          <div class="col-12 col-md-auto flex-1">
            <div>
              <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1">
                <label class="form-check-label mb-0 fs-0 me-2 line-clamp-1 flex-grow-1 flex-md-grow-0 cursor-pointer">{{$item->name}}</label>
                <div id="tag-{{$j}}">
                @if ($item->etat=='new')
                          <span class="badge badge-phoenix fs--2 badge-phoenix-primary">new</span>
                          @else
                            @if ($item->etat=='completed')
                              <span class="badge badge-phoenix fs--2 badge-phoenix-success">completed</span>
                              @else
                                  @if ($item->etat=='pending')
                                  <span class="badge badge-phoenix fs--2 badge-phoenix-info">ON Pending</span>
                                  @else
                                  <span class="badge badge-phoenix fs--2  badge-phoenix-secondary">Cancelled</span>
                                  @endif
                               @endif
                          @endif
                          @if ($item->etat!='cancelled')
                          @if ($item->prio==0)
                  <span class="badge badge-phoenix fs--2 mb-4 badge-phoenix-secondary">little</span>
                  @else
                    @if ($item->prio==1)
                    <span class="badge badge-phoenix fs--2 mb-4 badge-phoenix-warning">medium</span>
                      @else
                      @if ($item->prio==2)
                      <span class="badge badge-phoenix fs--2 mb-4 badge-phoenix-danger">Urgent</span>
                       @endif
                          @endif
                  @endif
                          @endif
                         
                        </div>
            </div>
            </div>
          </div>
          <div class="col-12 col-md-auto">
            <div class="d-flex ms-4 lh-1 align-items-center">
              <p class="text-700 fs--2 mb-md-0 me-2 me-md-3 mb-0">{{date('Y-m-d', strtotime($item->created_at))}}</p>
              <div class="hover-md-hide hover-lg-show hover-xl-hide">
                <p class="text-700 fs--2 ps-md-3 border-start-md border-300 fw-bold mb-md-0 mb-0">{{date('H:i', strtotime($item->created_at));}}</p>
              </div>
            </div>
          </div>
        </div>

        <div class="offcanvas offcanvas-end content-offcanvas offcanvas-backdrop-transparent border-start border-300 shadow-none bg-100" tabindex="-1" data-todo-content-offcanvas="data-todo-content-offcanvas" id="todoOffcanvas-{{$j}}">
          <div class="offcanvas-body p-0">
            <div class="p-5 p-md-6">
              <div class="d-flex flex-between-center align-items-start gap-5 mb-4">
                <h2 class="fw-bold fs-2 mb-0 text-1000">{{$item->name}}</h2>
              </div>
              @if (!($item->etat=='cancelled'))
              <div class="text-end mb-9">
                <button @if ($item->etat=='completed')
                @disabled(true)
            @endif  type="button" onclick="changeetat(event,'{{$item->id}}','tag-{{$j}}')" class="btn btn-phoenix-info">{{$item->etat=='pending'?'finished':'start'}}</button>
              </div>
              @endif
              <div class="mb-6">
                <div class="d-flex align-items-center mb-3">
                  <h4 class="text-900 me-3">Description</h4>
                </div>
                <p class="text-1000 mb-0">{{$item->desc}}</p>
              </div>
              
            </div>

            <div class="px-5 px-md-6">
              <h5 class="text-1000 mb-2">Feedback</h5>
              <div id="content{{$j}}">

              </div>
              <div class="flatpickr-input-container mb-4">
                <textarea id="message{{$j}}" class="form-control" aria-label="With textarea"></textarea>
                </div>
               
              <div class="text-end mb-9">
                <button type="button" onclick="add_com(event,'message{{$j}}','{{$item->id}}')" class="btn btn-phoenix-info">add feedback</button></div>
            </div>
          </div>
        </div>
        @endforeach
                
    @else
    <div class="alert alert-soft-primary" role="alert">No Task Found</div>        
    @endif

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
    const add_com=(event,txt,id)=>{
        const a =document.getElementById(txt).value;
        const b =id;
        
        if(!checkIfEmpty(a)){
            axios.post("{{route('feedback.add')}}",
            {
            message:a,
            _token:'{{ csrf_token() }}',
            tag_id:b,
            }).then(res=>alert(res.data))
        }else{
            console.log('empty');
        }
       
    }
    
    function changeetat(event, id, task) {
  const btn_ev = event.target.innerText.toLowerCase();
  const tag_ev = document.getElementById(task).children[0].innerText.toLowerCase();
  let etat = '';

  if (btn_ev === 'start' && (tag_ev === 'completed' || tag_ev === 'new')) {
    etat = 'pending';
  } else if (btn_ev === 'finished' && tag_ev === 'on pending') {
    etat = 'completed';
  }

  if (etat !== '') {
    axios.post("{{ route('task.edit.etat') }}", {
      new_etat: etat,
      _token: '{{ csrf_token() }}',
      tag_id: id,
    }).then(res => {
      if (res.data.message === 'etat update') {
        document.getElementById(task).innerHTML = '';
        const para = document.createElement("span");

        if (etat === 'pending') {
          para.innerText = 'ON Pending';
          para.className = 'badge badge-phoenix fs--2 badge-phoenix-info';
        } else if (etat === 'completed') {
          para.innerText = 'completed';
          para.className = 'badge badge-phoenix fs--2 badge-phoenix-success';
          event.target.disabled = true;
        }
        document.getElementById(task).appendChild(para);

        if (btn_ev === 'start') {
          event.target.innerText = 'finished';
        } else {
          event.target.innerText = 'start';
        }
      }
    });
  }
}
let intervalId = null;
var myArray = [];
function loadFeedback(data, id) {
  if (intervalId !== null) {
    clearInterval(intervalId);
  }
  intervalId = setInterval(() => {
    axios
      .get("{{ route('feedback') }}", {
        params: {
          id_tag: data,
          _token: '{{ csrf_token() }}',
        },
      })
      .then((res) => {
        if (res.data.length > 0) {
          res.data.forEach((feedback) => {
            if (!myArray.includes(feedback['id_feed'])) {
              const timestamp = feedback['date'];
              const [datePart, timePart] = timestamp.split('T');
              const feedbackData = {
                feedback: feedback['feedback'],
                date: datePart,
                author: feedback['author'],
                email: feedback['email'],
                image:feedback['image']
              };
              createFeedbackElement(id, feedbackData); 
              myArray.push(feedback['id_feed']);
            }
          });
        }
      })
      .catch((error) => {
        console.log('Error:', error);
      });
  }, 1000);
}
  function createFeedbackElement(id,feedbackData) {
            const contentDiv = document.getElementById(id);
            const outerDiv = document.createElement("div");
            outerDiv.classList.add("border-top", "border-200", "hover-actions-trigger", "py-3");
            const innerRow = document.createElement("div");
            innerRow.classList.add("row", "align-items-sm-center", "gx-2");
            const avatarCol = document.createElement("div");
            avatarCol.classList.add("col-auto");
            const avatarDiv = document.createElement("div");
            avatarDiv.classList.add("avatar", "avatar-s", "rounded-circle");
            const avatarImg = document.createElement("img");
            avatarImg.classList.add("rounded-circle", "avatar-placeholder");
            avatarImg.src = feedbackData.image;
            avatarImg.alt = "";
            const nameCol = document.createElement("div");
            nameCol.classList.add("col-auto");
            const nameParagraph = document.createElement("p");
            nameParagraph.classList.add("text-900", "fw-semi-bold", "inbox-link", "fs--1");
            nameParagraph.textContent = feedbackData.author;
            const timeCol = document.createElement("div");
            timeCol.classList.add("col-auto", "ms-auto");
            const timeSpan = document.createElement("span");
            timeSpan.classList.add("fs--2");
            timeSpan.textContent = feedbackData.date;
            const messageDiv = document.createElement("div");
            messageDiv.classList.add("ms-4", "mt-n3", "mt-sm-0", "ms-sm-11");
            const messageParagraph = document.createElement("p");
            messageParagraph.classList.add("fs--1", "ps-0", "text-700", "mb-0", "line-clamp-2");
            messageParagraph.textContent = feedbackData.feedback
            avatarDiv.appendChild(avatarImg);
            avatarCol.appendChild(avatarDiv);
            nameCol.appendChild(nameParagraph);
            timeCol.appendChild(timeSpan);
            messageDiv.appendChild(messageParagraph);
            innerRow.appendChild(avatarCol);
            innerRow.appendChild(nameCol);
            innerRow.appendChild(timeCol);
            outerDiv.appendChild(innerRow);
            outerDiv.appendChild(messageDiv);
            contentDiv.appendChild(outerDiv);
        }
</script>
@endsection