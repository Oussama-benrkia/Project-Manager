
<form class="row g-3 mb-6"Method="POST"  enctype="multipart/form-data">
    @csrf
    @method('POST')
      <div class="col-12 gy-6">
          <div class="form-floating">
            <input 
            value="{{old("email")}}"
            class="form-control @error('email') is-invalid @enderror" 
            id="email" 
            name="email" 
            type="email" 
            placeholder="email">
            <label for="email">Email</label>
          </div>
          @error('email')
                <p style="color: red">
                  email must no exist
                </p>
                @enderror
      </div>
      <div class="col-sm-6 col-md-4">
          <div class="form-icon-container">
              <div class="form-floating">
                <input 
                value="{{old("firstName")}}"
                class="form-control form-icon-input @error('firstName') is-invalid @enderror" 
                id="firstName" 
                name="firstName" 
                type="text" 
                placeholder="First Name">
                <label class="text-700 form-icon-label" for="firstName">FIRST NAME</label>
              </div>
              <span class="fa-solid fa-user text-900 fs--1 form-icon"></span>
            </div>
            @error('firstName')
          <p style="color: red">
            First Name field must be filled in
          </p>
          @enderror
      </div>
      
      <div class="col-sm-6 col-md-4">
          <div class="form-icon-container">
              <div class="form-floating">
                <input class="form-control form-icon-input @error('lastName') is-invalid @enderror" 
                value="{{old("lastName")}}"
                id="lastName" 
                name="lastName" 
                type="text" 
                placeholder="Last Name">
                <label class="text-700 form-icon-label" for="lastName">Last NAME</label>
              </div>
              <span class="fa-solid fa-user text-900 fs--1 form-icon"></span>
            </div>
            @error('lastName')
                  <p style="color: red">
                    Last Name field must be filled in
                  </p>
                  @enderror
      </div>
      <div class="col-sm-6 col-md-4">
          <div class="form-icon-container">
            <div class="form-floating">
              <input 
              value="{{old("tel")}}"
              class="form-control form-icon-input @error('tel') is-invalid @enderror" 
              id="tel" 
              type="tel"
              value="{{old("tel")}}"
               placeholder="tel"
               name="tel">
           
               <label class="text-700 form-icon-label" for="tel">ENTER YOUR PHONE</label>
              </div>
              <span class="fa-solid fa-phone text-900 fs--1 form-icon"></span>
          </div>
          @error('tel')
                <p style="color: red">
                  telephone field must be filled in
                </p>
                @enderror
        </div>

      <div class="col-sm-6 col-md-4">
          <div class="form-floating">
            <input 
            class="form-control @error('Password') is-invalid @enderror"
            value="{{old("Password")}}"
            id="Password"
             name="password" 
             type="password" 
             placeholder="password"
             ><label for="Password">Password</label>
            </div>
            @error('password')
            <p style="color: red">
              password field must be filled in
            </p>
            @enderror
        </div>


        <div class="col-sm-6 col-md-4">
          <div class="form-floating">
            <input 
            class="form-control @error('password_confirmation') is-invalid @enderror"
            name="password_confirmation"
            id="password_confirmation"
            type="password" 
            placeholder="password confirmation">
            <label for="floatingInputGrid">confimer Pasword</label></div>
            @error('password')
            <p style="color: red">
              The password must be the same
            </p>
            @enderror
          </div>
        <div class="col-12 gy-6">
          <label class="form-label " for="formFileMultiple">add image</label>
          <input class="form-control @error('image') is-invalid @enderror" 
          id="file" type="file" name="image" />
          @error('image')
          <p style="color: red">
            select image
          </p>           
          @enderror
        </div>
    <div class="col-12 gy-6">
      <div class="row g-3 justify-content-end">
        <div class="col-auto"><button class="btn btn-primary px-5 px-sm-15">Create User</button></div>
      </div>
    </div>
  </form>
