<form class="row g-3 mb-6" Method="POST" action="{{route('task.insert')}}" >
  <input type="hidden" value="insert" id="eventtype">
    @csrf
    @method('POST')
      <div class="col-12 gy-6">
          <div class="form-floating">
            <input 
            value="{{old("name")}}"
            class="form-control @error('name') is-invalid @enderror" 
            id="name" 
            name="name" 
            type="name" 
            placeholder="name">
            <label for="name">name</label>
          </div>
          @error('name')
          <p style="color: red">
            Name field must be filled in
          </p>
          @enderror
      </div>

      <div class="col-md-6 gy-6" >
        <select name="id_pr" onchange="getemp('id_pr')" class="form-select" id="id_pr"   data-options='{"removeItemButton":true,"placeholder":true}'>
        <option value="" @if ($id==0)
        @selected(true)
    @endif disabled>Add Projet</option>
        @foreach ($data['projet'] as $item)
            <option value="{{$item->id}}" @if ($id==$item->id)
              @selected(true)
          @endif >{{$item->nom}}</option>
        @endforeach
        </select>
        @error('id_pr')
                <p style="color: red">
                  choose a project
                </p>
                @enderror
        </div>
        
        <div class="col-md-6 gy-6">
            <select  onchange="select_emp(event)" name="id_em" class="form-select" id="id_em"  data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="" @selected(true)  disabled>Add employee</option>
        </select>
        @error('id_em')
                <p style="color: red">
                  choose a employee
                </p>
                @enderror
      </div>
      <div class="col-md-6 gy-6">
        <div class="flatpickr-input-container">
          <div class="form-floating">
            <input name="da_sta" class="form-control datetimepicker flatpickr-input active @error('da_sta') is-invalid @enderror" id="floatingInputStartDate" type="text" placeholder="end date" data-options="{&quot;disableMobile&quot;:true}" readonly="readonly">
            <label class="ps-6" for="floatingInputStartDate">Start date</label>
            <span class="uil uil-calendar-alt flatpickr-icon text-700"></span>
            </div>
            @error('da_sta')
            <p style="color: red">
              Date must be selected 
           </p>
            @enderror
        </div>
      </div>
      <div class="col-md-6 gy-6">
        <div class="flatpickr-input-container">
          <div class="form-floating">
            <input name="da_end" class="form-control datetimepicker flatpickr-input active @error('da_end') is-invalid @enderror" id="floatingInputStartDate2" type="text" placeholder="end date" data-options="{&quot;disableMobile&quot;:true}" readonly="readonly">
            <label class="ps-6" for="floatingInputStartDate2">end date</label>
            <span class="uil uil-calendar-alt flatpickr-icon text-700"></span>
            </div>
        </div>
        @error('da_end')
        <p style="color: red">
          End date must be greater than start date
        </p>
        @enderror
      </div>
      
      <div class="col-12 gy-6" id='tim' style="display: none">
        <div class="centered-text">
          <p id="date"></p>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <input type="hidden" id="start">
          <input type="hidden" id="end">
          <button onclick="start__()" class="btn btn-phoenix-secondary rounded-pill" type="button">&larr;</button>
          <button onclick="end__()" class="btn btn-phoenix-secondary rounded-pill" type="button">&rarr;</button>
        </div>
          <div  class="container d-flex justify-content-center"> 
            <div class="line_a"></div>
          <div class="row">
            <div class="col">
              <div class="timeline-steps aos-init aos-animate" id="item" data-aos="fade-up">
               
              </div>
            </div>
          </div>
        </div>
      </div>
        <div class="col-12 gy-6">
        <div class="form-floating">
            <textarea name="desc" id="desc" class="form-control @error('desc') is-invalid @enderror" name="desc" cols="30" rows="10"></textarea>
            <label for="desc">desc</label>
        </div>
        @error('desc')
        <p style="color: red">
          description field must be filled in
        </p>
        @enderror</div>

        </div> 
    <div class="col-12 gy-6">
        <h5 style="color: gray">task priority :</h5>
          <div class="form-check form-check-inline">
            <input class="form-check-input" id="inlineRadio1" type="radio" name="urgent" value="little" name="urgent" @checked(true)/>
            <label class="form-check-label" for="inlineRadio1">little</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" id="inlineRadio1" type="radio" name="urgent" value="medium" name="urgent"/>
            <label class="form-check-label" for="inlineRadio1">medium</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" id="inlineRadio2" type="radio" name="urgent" value="urgent" name="urgent"/>
            <label class="form-check-label" for="inlineRadio2">urgent</label>
          </div>

      <div class="row g-3 justify-content-end">
        <div class="col-auto"><button class="btn btn-primary px-5 px-sm-15">Create Task</button></div>
      </div>
    </div>
  </form>

 <script src="{{asset('assets/js/all.js')}}"></script>
