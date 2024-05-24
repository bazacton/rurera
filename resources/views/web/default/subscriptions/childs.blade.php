@include('web.default.subscriptions.steps',['activeStep'=> 'student'])
<div class="form-login-reading">
    <div class="container">
      <form class="child-register-form" method="post" action="javascript:;">
          {{ csrf_field() }}
      <div class="bg-white panel-border p-25 rounded-sm mt-30 mx-auto w-80">
      <div class="row">
        <div class="col-12 col-lg-12 col-md-12 col-sm-12 mb-10">
          <h2 class="font-22">Student's details</h2>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 mx-auto">
          <div class="row">


            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <span class="fomr-label">Student's first name</span>
                    <div class="input-field">
                        <input type="text" class="user-first-name rurera-req-field" placeholder="First Name" name="first_name">
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <span class="fomr-label">Student's last name</span>
                    <div class="input-field">
                        <input type="text" class="user-last-name rurera-req-field" placeholder="Last name" name="last_name">
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-12 col-md-6 col-lg-6">
                  <div class="form-group">
                      <span class="fomr-label">Year Group</span>
                      <select class="form-control @error('category_id') is-invalid @enderror rurera-req-field"
                              name="year_id">
                          <option {{ !empty($trend) ?
                          '' : 'selected' }} disabled>Choose Year Group</option>

                          @foreach($categories as $category)
                          @if(!empty($category->subCategories) and count($category->subCategories))
                          <optgroup label="{{  $category->title }}">
                              @foreach($category->subCategories as $subCategory)
                              <option value="{{ $subCategory->id }}" @if(!empty($class) and $class->
                                  category_id == $subCategory->id) selected="selected" @endif>{{
                                  $subCategory->title }}
                              </option>
                              @endforeach
                          </optgroup>
                          @else
                          <option value="{{ $category->id }}" class="font-weight-bold" @if(!empty($class)
                                  and $class->category_id == $category->id) selected="selected" @endif>{{
                              $category->title }}
                          </option>
                          @endif
                          @endforeach
                      </select>
                  </div>
          </div>

		  <div class="col-12">
			<div class="edit-element-title mb-20">
				<h6 class="font-weight-500">
					School Preference
				</h6>
			</div>
		</div>

          <div class="col-6 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <span class="fomr-label">Test Prep School Choice</span>
                        <select class="form-control rurera-req-field"
                                name="test_prep_school">
                            <option value="Not sure" selected>Not sure</option>
                            <option value="Independent schools">Independent schools</option>
                            <option value="Grammar schools">Grammar schools</option>
                            <option value="Independent & grammar schools">Independent & grammar schools</option>
                        </select>
                    </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <span class="fomr-label">Username</span>
                    <div class="input-field">
                        <input type="text" name="username" class="username-field rurera-req-field rurera-min-char rurera-no-space" data-min="6" placeholder="Username">
                        <a href="javascript:;" class="username-auto-generate rurera-hide">Generate</a>
                    </div>
                </div>
                <div class="usernames-suggestions">
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <span class="fomr-label">Password</span>
                    <div class="input-field">
                        <input type="text" class="password-field rurera-req-field" name="password" placeholder="Create a password">
                        <a href="javascript:;" class="generatePassword" data-input_class="password-field">Generate</a>
                    </div>
                </div>
                <div class="password-suggestions">
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group mt-30">
                    <div class="btn-field">
                        <button type="submit" class="nav-link">Create student's profile</button>
                    </div>
                </div>
            </div>
            <!-- <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <a href="#" class="nav-link btn-primary rounded-pill mb-25 text-center" id="book-tab" data-toggle="tab" data-target="#book" type="button" role="tab" aria-controls="book" aria-selected="true"> continue </a>
                </div>
            </div>
            <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center">
                <p class="mb-20">By Clicking on Start Free Trial, I agree to the <a href="#">Terms of Service</a>And <a href="#">Privacy Policy</a>
                </p>
                <div class="subscription mb-20">
                <span>Already have a subscription? <a href="#" id="contact-tab" data-toggle="tab" data-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">log in</a>
                </span>
            </div> -->
            </div>
          </div>
        </div>
          </div>
        </form>
      </div>
    </div>
