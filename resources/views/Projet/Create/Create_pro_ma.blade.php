        

  <form class="row g-3 mb-6" method="POST" action="{{route('project.insert')}}">
    @csrf
    <div class="col-12 gy-6">
      <div class="form-floating">
          <input value="{{old('nom')}}" name='nom' class="form-control @error('nom') is-invalid @enderror" id="floatingInputGrid" type="text" placeholder="Project title">
          <label for="floatingInputGrid">Project title</label>
      </div>    @error('nom')
                <p style="color: red">
                  Name field must be filled in
                </p>
                @enderror
    </div>

    <div class="col-md-6 gy-6">
      <div class="flatpickr-input-container">
        <div class="form-floating">
          <input value="{{old('date_deb')}}" name="date_deb" class="form-control datetimepicker flatpickr-input active @error('date_deb') is-invalid @enderror" id="floatingInputStartDate" type="text" placeholder="start date" data-options="{&quot;disableMobile&quot;:true}" readonly="readonly">
          <label class="ps-6" for="floatingInputStartDate">Start date</label>
          <span class="uil uil-calendar-alt flatpickr-icon text-700"></span>
          </div>
      </div>    @error('date_deb')
                <p style="color: red">
                   Date must be selected 
                </p>
                @enderror
    </div>

    <div class="col-md-6 gy-6">
      <div class="flatpickr-input-container">
        <div class="form-floating">
          <input value="{{old('date_fin')}}" name="date_fin" class="form-control datetimepicker flatpickr-input active @error('date_fin') is-invalid @enderror" id="floatingInputStartDate2" type="text" placeholder="end date" data-options="{&quot;disableMobile&quot;:true}" readonly="readonly">
          <label class="ps-6" for="floatingInputStartDate2">end date</label>
          <span class="uil uil-calendar-alt flatpickr-icon text-700"></span>
          </div>
      </div>
        @error('date_fin')
                <p style="color: red">
                  End date must be greater than start date
                </p>
                @enderror
</div>

    <div class="col-12 gy-6">
      <div class="form-floating">
        <textarea 
        class="form-control @error('desc') is-invalid @enderror" value="{{old('desc')}}"
        name="desc" id="floatingProjectOverview" placeholder="Leave a comment here" style="height: 100px"></textarea><label for="floatingProjectOverview">project overview</label></div>
        @error('desc')
                <p style="color: red">
                  description field must be filled in
                </p>
                @enderror</div>


    <div class="col-12 gy-6">
      <div class="row g-3 justify-content-end">
        <div class="col-auto"><button class="btn btn-primary px-5 px-sm-15">Create Project</button></div>
      </div>
    </div>
  </form>
