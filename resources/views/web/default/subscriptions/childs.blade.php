@include('web.default.subscriptions.steps',['activeStep'=> 'student'])
<div class="form-login-reading">
    <div class="container">
      <form class="child-register-form" method="post" action="javascript:;">
          {{ csrf_field() }}
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
                        <input type="text" class="user-first-name" placeholder="Name" name="first_name">
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <span class="fomr-label">Student's last name</span>
                    <div class="input-field">
                        <input type="text" class="user-last-name" placeholder="Last name" name="last_name">
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-12 col-md-6 col-lg-6">
                  <div class="form-group">
                      <span class="fomr-label">Year Group</span>
                      <select class="form-control @error('category_id') is-invalid @enderror"
                              name="year_id">
                          <option {{ !empty($trend) ?
                          '' : 'selected' }} disabled>{{ trans('admin/main.choose_category') }}</option>

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
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <h5>Students's account details</h5>
            </div>
              <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="plan-switch-option">
                        <span class="switch-label font-18">Auto Generate</span> &nbsp;&nbsp;
                        <div class="plan-switch">
                            <div class="custom-control custom-switch"><input type="checkbox" name="auto_generate" class="username-auto-generate custom-control-input" id="auto_generate"><label class="custom-control-label"  for="auto_generate"></label></div>
                        </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <span class="fomr-label">Username</span>
                    <div class="input-field">
                        <input type="text" name="username" class="username-field" placeholder="Username">
                    </div>
                </div>
                <div class="usernames-suggestions">
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <span class="fomr-label">Password</span>
                    <div class="input-field">
                        <input type="password" class="password-field" name="password" placeholder="Create a password">
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
        </form>
      </div>
    </div>
