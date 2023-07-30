
<form method="POST" class="row g-3 mb-6" action="{{route('project.update',['id'=>$data->id])}}">

  @csrf
  <div class="col-12 gy-6">
    <div class="form-floating">
        <input value="{{$data->nom}}" name='nom' class="form-control @error('nom') is-invalid @enderror" id="floatingInputGrid" type="text" placeholder="Project title">
        <label for="floatingInputGrid">Project title</label>
    </div>
    @error('nom')
    <p style="color: red">
      Name field must be filled in
    </p>
    @enderror
  </div>
  <div class="col-md-6 gy-6">
    <div class="flatpickr-input-container">
      <div class="form-floating">
        <input value="{{$data->date_deb}}" name="date_deb" class="form-control datetimepicker flatpickr-input active @error('date_deb') is-invalid @enderror" id="floatingInputStartDate" type="text" placeholder="start date" data-options="{&quot;disableMobile&quot;:true}" readonly="readonly">
        <label class="ps-6" for="floatingInputStartDate">Start date</label>
        <span class="uil uil-calendar-alt flatpickr-icon text-700"></span>
        </div>
        @error('date_deb')
                <p style="color: red">
                   Date must be selected 
                </p>
                @enderror
    </div>
  </div>
  <div class="col-md-6 gy-6">
    <div class="flatpickr-input-container">
      <div class="form-floating">
        <input value="{{$data->date_fin}}" name="date_fin" class="form-control datetimepicker flatpickr-input active @error('date_fin') is-invalid @enderror" id="floatingInputStartDate2" type="text" placeholder="end date" data-options="{&quot;disableMobile&quot;:true}" readonly="readonly">
        <label class="ps-6" for="floatingInputStartDate2">end date</label>
        <span class="uil uil-calendar-alt flatpickr-icon text-700"></span>
        </div>
        @error('date_fin')
                <p style="color: red">
                  End date must be greater than start date
                </p>
                @enderror
    </div>
  </div>
  <div class="col-12 gy-6">
    <div class="form-floating">
      <textarea 
      class="form-control @error('desc') is-invalid @enderror" 
      name="desc" id="floatingProjectOverview" placeholder="Leave a comment here" style="height: 100px">{{$data->desc}}</textarea><label for="floatingProjectOverview">project overview</label>
    </div>
    @error('desc')
                <p style="color: red">
                  description field must be filled in
                </p>
                @enderror
  </div>
  <div class="col-12 gy-6">
    <select name="id_ma" class="form-select @error('id_ma') is-invalid @enderror" id="organizerMultiple2"  data-options='{"removeItemButton":true,"placeholder":true}'>
    <option value=""  disabled>Add Manger</option>
    @foreach ($man as $item)
    <option value="{{$item->id}}" @if ($item->id==$data->user_id)
      @selected(true) 
    @endif>{{$item->firstName.' '.$item->lastName}}</option>
    @endforeach

</select>
@error('id_ma')
                <p style="color: red">
                  choose a manager
                </p>
                @enderror
</div>
  <div class="col-12 gy-6">
    <div class="form-check form-switch">
      <input class="form-check-input"@if ($data->etat=='cancelled')
          @checked(true)
      @endif id="flexSwitchCheckChecked" type="checkbox" name="Cancelled"/>
      <label class="form-check-label" for="flexSwitchCheckChecked">Cancelled</label>
    </div>
    <div class="row g-3 justify-content-end">
      <div class="col-auto"><button class="btn btn-primary px-5 px-sm-15">Update Project</button></div>
    </div>
  </div>
</form>
