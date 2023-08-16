@extends(getTemplate() .'.panel.layouts.panel_layout')

@push('styles_top')
<style type="text/css">
    .frontend-field-error, .field-holder:has(.frontend-field-error),
    .form-field:has(.frontend-field-error), .input-holder:has(.frontend-field-error) {
        border: 1px solid #dd4343;
    }

    .hide {
        display: none;
    }
</style>
@endpush

@section('content')
<section class="">
    <div class="d-flex align-items-start align-items-md-center justify-content-between flex-column flex-md-row">
        <h1 class="section-title">{{ trans('panel.dashboard') }}</h1>
        <br><br><br>
    </div>
</section>

<section class="dashboard">

    <div class="db-form-tabs">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab"
                   aria-controls="general" aria-selected="true">General</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="billing-tab" data-toggle="tab" href="#billing" role="tab"
                   aria-controls="billing" aria-selected="false">Billing</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="members-tab" data-toggle="tab" href="#members" role="tab"
                   aria-controls="members" aria-selected="false">Members</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="security-tab" data-toggle="tab" href="#security" role="tab"
                   aria-controls="security" aria-selected="false">Security</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="notifications-tab" data-toggle="tab" href="#notifications" role="tab"
                   aria-controls="notifications" aria-selected="false">Notifications</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="FAQs-tab" data-toggle="tab" href="#FAQs" role="tab" aria-controls="FAQs"
                   aria-selected="false">FAQs</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                <form action="/panel/setting/update-user" method="post" class="w-100">
                        {{ csrf_field() }}
                <div class="lms-jobs-form">
                    <div class="row">
                        <div class="col-12 col-lg-4 col-md-6">
                            <div class="input-field">
                                <input type="text" name="full_name" value="{{$userObj->full_name}}" placeholder="Full Name">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 col-md-6">
                            <div class="input-field">
                                <input type="email" name="email" value="{{$userObj->email}}"  placeholder="Email address">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 col-md-6">
                            <div class="input-field select-arrow">
                                <select name="country_label" class="lms-jobs-select">
                                    <option value="" selected="selected">Country</option>
                                    @if( !empty( $countries_list ) )
                                        @foreach($countries_list as $countryObj)
                                           @php $is_selected = ($userObj->country_label == $countryObj['value'])? 'selected' : ''; @endphp
                                            <option {{$is_selected}} value="{{ isset( $countryObj['value'] )? $countryObj['value'] : ''}}">{{ isset( $countryObj['label'] )? $countryObj['label'] : ''}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 col-md-6">
                            <div class="input-field">
                                <input type="text" value="{{$userObj->postal_code}}" name="postal_code" placeholder="Postal Code">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 col-md-6">
                            <div class="input-field select-arrow">
                                <select name="time_zone" class="lms-jobs-select">
                                    <option value="" selected="selected">Time Zone</option>
                                    @if( !empty( $time_zones ) )
                                        @foreach($time_zones as $timeZoneData)

                                            @php $is_selected = ($userObj->timezone == $timeZoneData['value'])? 'selected' : ''; @endphp
                                            <option {{$is_selected}} value="{{ isset( $timeZoneData['value'] )? $timeZoneData['value'] : ''}}">{{ isset( $timeZoneData['label'] )? $timeZoneData['label'] : ''}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 col-md-6">
                            <div class="input-field select-arrow">
                                <select name="course_eidtion" class="lms-jobs-select">
                                    <option value="" selected="selected">Course Edition</option>
                                    <option value="">timezone</option>
                                    <option value="">Course Edition</option>
                                    <option value="">English</option>
                                    <option value="">Computing</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-field">
                                <label for="avatar">Select Avatar</label>
                                <input type="file" id="avatar">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-field">
                                <label>Complete Address (invoice/Shipping)</label>
                                <textarea name="complete_address">{{$userObj->address}}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="field-btn">
                                <button type="submit" class="submit-btn">Update Details</button>
                                <a href="#" class="cancel-btn">Cancel</a>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5 class="card-title fw-normal">Delete your account</h5>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted">Please note, deleting your account is a permanent action and
                                        will no be recoverable once completed.</p>
                                    <button class="btn btn-danger">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <div class="tab-pane fade" id="billing" role="tabpanel" aria-labelledby="billing-tab">
                <div class="db-billing">
                    <div class="row">
                        <div class="col-12">
                            <div class="billing-card">
                                <div class="card-body">
                                    <span class="text-plan">Current plan</span>
                                    <h4 class="mb-0 mt-2">$39/ per month</h4>
                                </div>
                                <div class="card-footer">
                                    <div class="alert alert-danger mb-0">
                                        You are near your API limits.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="billing-card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">Payment methods</h6>
                                    <a class="btn btn-sm btn-primary" href="#!">Add method</a>
                                </div>
                                <div class="card-body">
                                    <div class="list-group list-group-custom list-group-flush my-2">
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <img src="assets/images/visa.svg" alt="#">
                                                </div>
                                                <div class="col ml-n2">
                                                    <h6 class="mb-0">Visa ending in 7878</h6>
                                                    <small class="text-muted">Expires 08/2022</small>
                                                </div>
                                                <div class="col-auto mr-n3">
                                                    <span class="badge bg-light text-dark">Default</span>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" class="dropdown-toggle after-none"
                                                       data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2 rounded-4">
                                                        <li><a class="dropdown-item" href="#">File Info</a></li>
                                                        <li><a class="dropdown-item" href="#">Copy to</a></li>
                                                        <li><a class="dropdown-item" href="#">Move to</a></li>
                                                        <li><a class="dropdown-item" href="#">Rename</a></li>
                                                        <li><a class="dropdown-item" href="#">Block</a></li>
                                                        <li><a class="dropdown-item" href="#">Delete</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="billing-card">
                                <div class="card-header">
                                    <div>
                                        <h5 class="card-title fw-normal mb-0">Invoices</h5>
                                        <small class="text-muted">Showing data from</small>
                                    </div>
                                    <div class="card-action">
                                        <div class="dropdown">
                                            <a href="#" class="card-options-remove text-danger"
                                               data-toggle="card-remove">
                                                <img src="assets/images/svg" alt="">
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 p-2">
                                                <a href="javascript:void(0)" class="dropdown-item"><i
                                                            class="me-3 fa fa-share"></i>Share</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-border table-hover table-nowrap card-table mb-0">
                                        <thead>
                                        <tr>
                                            <th>Invoice ID</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody class="font-size-base">
                                        <tr>
                                            <td><a href="invoices.html">Invoice #10022</a></td>
                                            <td>Oct. 24, 2020</td>
                                            <td>$29.00</td>
                                            <td><span class="badge bg-secondary">Outstanding</span></td>
                                        </tr>
                                        <tr>
                                            <td><a href="invoices.html">Invoice #10012</a></td>
                                            <td>Aug. 11, 2020</td>
                                            <td>$29.00</td>
                                            <td><span class="badge bg-success">Paid</span></td>
                                        </tr>
                                        <tr>
                                            <td><a href="invoices.html">Invoice #10043</a></td>
                                            <td>July. 5, 2020</td>
                                            <td>$29.00</td>
                                            <td><span class="badge bg-success">Paid</span></td>
                                        </tr>
                                        <tr>
                                            <td><a href="invoices.html">Invoice #10045</a></td>
                                            <td>Jun. 16, 2020</td>
                                            <td>$29.00</td>
                                            <td><span class="badge bg-success">Paid</span></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="members" role="tabpanel" aria-labelledby="members-tab">
                <div class="db-members">
                    <div class="row g-3 list-unstyled">
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="text-uppercase text-muted small mb-1">Seats used</p>
                                            <h4 class="mb-0">4 out of 6</h4>
                                        </div>
                                        <div class="col-auto">
                                            <a class="btn btn-sm btn-outline-primary" href="#!">Upgrade</a>
                                        </div>
                                    </div> <!--[ row end ]-->
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="text-uppercase text-muted small mb-1">Default role</p>
                                            <h4 class="h4 mb-0">Staff</h4>
                                        </div>
                                        <div class="col-auto">
                                            <a class="btn btn-sm btn-dark" href="#!">Change</a>
                                        </div>
                                    </div> <!--[ row end ]-->
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5 class="card-title fw-normal mb-0">Members</h5>
                                    <!--[ Dropdown ]-->
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">Invite member
                                        </button>
                                        <form class="dropdown-menu dropdown-menu-end border-0 rounded-4 shadow"
                                              style="width: 300px;">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">Invite a member</h6>
                                                <span class="badge bg-primary">2 seats left</span>
                                            </div>
                                            <div class="card-body">
                                                <div class="row g-0 align-items-center mb-2">
                                                    <div class="col-3">
                                                        <label class="mb-0">Name</label>
                                                    </div>
                                                    <div class="col">
                                                        <input class="form-control form-control-flush" type="text"
                                                               placeholder="Full name">
                                                    </div>
                                                </div> <!--[ row end ]-->
                                                <div class="row g-0 align-items-center mb-2">
                                                    <div class="col-3">
                                                        <label class="mb-0">Email</label>
                                                    </div>
                                                    <div class="col">
                                                        <input class="form-control form-control-flush" type="text"
                                                               placeholder="Email address">
                                                    </div>
                                                </div> <!--[ row end ]-->
                                                <div class="row g-0 align-items-center">
                                                    <div class="col-3">
                                                    </div>
                                                    <div class="col">
                                                        <button class="btn btn-block btn-primary" type="submit">Invite
                                                            member
                                                        </button>
                                                    </div>
                                                </div> <!--[ row end ]-->
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="list-group list-group-custom list-group-flush mb-0">
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <a href="#" class="avatar"><img src="./assets/images/avatar1.jpg"
                                                                                    alt="..."
                                                                                    class="avatar rounded-circle"></a>
                                                </div>
                                                <div class="col-5 ms-2">
                                                    <h6 class="mb-1"><a href="#">amelia green</a></h6>
                                                    <small class="text-muted">amelia.green@company.com</small>
                                                </div>
                                                <div class="col-auto ms-auto mr-md-3">
                                                    <select class="form-control custom-select" data-bs-toggle="select">
                                                        <option value="1">Admin</option>
                                                        <option value="2">Staff</option>
                                                        <option value="3">Custom</option>
                                                    </select>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" class="dropdown-toggle after-none"
                                                       data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2 rounded-4">
                                                        <li><a class="dropdown-item" href="#">File Info</a></li>
                                                        <li><a class="dropdown-item" href="#">Copy to</a></li>
                                                        <li><a class="dropdown-item" href="#">Move to</a></li>
                                                        <li><a class="dropdown-item" href="#">Rename</a></li>
                                                        <li><a class="dropdown-item" href="#">Block</a></li>
                                                        <li><a class="dropdown-item" href="#">Delete</a></li>
                                                    </ul>
                                                </div>
                                            </div> <!--[ row end ]-->
                                        </div>
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <a href="#" class="avatar"><img src="./assets/images/avatar2.jpg"
                                                                                    alt="..."
                                                                                    class="avatar rounded-circle"></a>
                                                </div>
                                                <div class="col-5 ms-2">
                                                    <h6 class="mb-1"><a href="#">charlotte green</a></h6>
                                                    <small class="text-muted">charlotte.green@company.com</small>
                                                </div>
                                                <div class="col-auto ms-auto mr-md-3">
                                                    <select class="form-control custom-select" data-bs-toggle="select">
                                                        <option value="1">Admin</option>
                                                        <option value="2">Staff</option>
                                                        <option value="3">Custom</option>
                                                    </select>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" class="dropdown-toggle after-none"
                                                       data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2 rounded-4">
                                                        <li><a class="dropdown-item" href="#">File Info</a></li>
                                                        <li><a class="dropdown-item" href="#">Copy to</a></li>
                                                        <li><a class="dropdown-item" href="#">Move to</a></li>
                                                        <li><a class="dropdown-item" href="#">Rename</a></li>
                                                        <li><a class="dropdown-item" href="#">Block</a></li>
                                                        <li><a class="dropdown-item" href="#">Delete</a></li>
                                                    </ul>
                                                </div>
                                            </div> <!--[ row end ]-->
                                        </div>
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <a href="#" class="avatar"><img src="./assets/images/avatar3.jpg"
                                                                                    alt="..."
                                                                                    class="avatar rounded-circle"></a>
                                                </div>
                                                <div class="col-5 ms-2">
                                                    <h6 class="mb-1"><a href="#">susie willis</a></h6>
                                                    <small class="text-muted">susie.willis@company.com</small>
                                                </div>
                                                <div class="col-auto ms-auto mr-md-3">
                                                    <select class="form-control custom-select" data-bs-toggle="select">
                                                        <option value="1">Admin</option>
                                                        <option value="2">Staff</option>
                                                        <option value="3">Custom</option>
                                                    </select>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" class="dropdown-toggle after-none"
                                                       data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2 rounded-4">
                                                        <li><a class="dropdown-item" href="#">File Info</a></li>
                                                        <li><a class="dropdown-item" href="#">Copy to</a></li>
                                                        <li><a class="dropdown-item" href="#">Move to</a></li>
                                                        <li><a class="dropdown-item" href="#">Rename</a></li>
                                                        <li><a class="dropdown-item" href="#">Block</a></li>
                                                        <li><a class="dropdown-item" href="#">Delete</a></li>
                                                    </ul>
                                                </div>
                                            </div> <!--[ row end ]-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                <div class="db-security">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title fw-normal">Change your password</h5>
                                    <p class="text-muted">We will email you a confirmation when changing your password,
                                        so please expect that email after submitting.</p>
                                    <button class="btn btn-warning">Forgot your password?</button>
                                </div>
                                <div class="card-footer">
                                    <form class="row g-3 justify-content-between">
                                        <div class="col-lg-4 col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Current password</label>
                                                <input type="password" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">New password</label>
                                                <input type="password" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Confirm password</label>
                                                <input type="password" class="form-control">
                                            </div>
                                            <button type="button" class="btn btn-primary">Update Password</button>
                                            <button type="button" class="btn btn-link">Cancel</button>
                                        </div>
                                        <div class="col-lg-7 col-md-12">
                                            <div class="bg-body border dashed p-3">
                                                <h6 class="mb-2">Password requirements</h6>
                                                <p class="text-muted mb-2">To create a new password, you have to meet
                                                    all of the following requirements:</p>
                                                <!--[ List group ]-->
                                                <ul class="small text-muted lh-lg mb-0">
                                                    <li>Minimum 8 character</li>
                                                    <li>At least one special character</li>
                                                    <li>At least one number</li>
                                                    <li>Can’t be the same as a previous password</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5>Device History</h5>
                                    <p class="text-muted">If you see a device here that you believe wasn’t you, please
                                        contact our account fraud department immediately.</p>
                                    <button class="btn btn-dark">Log out all devices</button>
                                </div>
                                <div class="card-footer p-0">
                                    <div class="list-group list-group-custom list-group-flush mb-0">
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar lg text-center"><i
                                                                class="fa fa-mobile fa-3x"></i></div>
                                                </div>
                                                <div class="col ml-n2">
                                                    <h6 class="mb-1">iPhone 11</h6>
                                                    <small class="text-muted">Brownsville, VT ·
                                                        <span>Jun 11 at 10:05am</span></small>
                                                </div>
                                                <div class="col-auto">
                                                    <button class="btn btn-sm btn-white">Sign out</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar lg text-center"><i
                                                                class="fa fa-desktop fa-2x"></i></div>
                                                </div>
                                                <div class="col ml-n2">
                                                    <h6 class="mb-1">iMac OSX · <span class="font-weight-normal">Safari 10.2</span>
                                                    </h6>
                                                    <small class="text-muted">Ct, Corona, CA · <span>September 14 at 2:30pm</span></small>
                                                </div>
                                                <div class="col-auto">
                                                    <button class="btn btn-sm btn-white">Sign out</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar lg text-center"><i
                                                                class="fa fa-laptop fa-3x"></i></div>
                                                </div>
                                                <div class="col ml-n2">
                                                    <h6 class="mb-1">HP Laptop Win10</h6>
                                                    <small class="text-muted">Ct, Corona, CA · <span>September 16 at 11:16am</span></small>
                                                </div>
                                                <div class="col-auto">
                                                    <button class="btn btn-sm btn-white">Sign out</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar lg text-center"><i
                                                                class="fa fa-desktop fa-2x"></i></div>
                                                </div>
                                                <div class="col ml-n2">
                                                    <h6 class="mb-1">iMac OSX · <span class="font-weight-normal">Edge browser</span>
                                                    </h6>
                                                    <small class="text-muted">Huntington Station, NY · <span>October 26 at 5:16pm</span></small>
                                                </div>
                                                <div class="col-auto">
                                                    <button class="btn btn-sm btn-white">Sign out</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="notifications" role="tabpanel" aria-labelledby="notifications-tab">
                <div class="db-notifications">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <div>
                                        <h5 class="card-title fw-normal mb-0">Notifications Setting</h5>
                                        <small class="text-muted">We may still send you important Notifications about
                                            your account outside of your Notifications settings.</small>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-custom list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-start py-4">
                                            <div>
                                                <h6>Comments</h6>
                                                <small class="text-muted">These are notifications for comments on your
                                                    posts and replies to your comments.</small>
                                            </div>
                                            <div>
                                                <div class="form-check form-switch form-check-inline">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="noti_email" checked="">
                                                    <label class="form-check-label" for="noti_email">Email</label>
                                                </div>
                                                <div class="form-check form-switch form-check-inline">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="noti_push" checked="">
                                                    <label class="form-check-label" for="noti_push">Push</label>
                                                </div>
                                                <div class="form-check form-switch form-check-inline">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="noti_sms">
                                                    <label class="form-check-label" for="noti_sms">SMS</label>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-start py-4">
                                            <div>
                                                <h6>Reminders</h6>
                                                <small class="text-muted">These are notificatios to remind you of
                                                    updates you might have missed.</small>
                                            </div>
                                            <div>
                                                <div class="form-check form-switch form-check-inline">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="noti_email2" checked="">
                                                    <label class="form-check-label" for="noti_email2">Email</label>
                                                </div>
                                                <div class="form-check form-switch form-check-inline">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="noti_push2" checked="">
                                                    <label class="form-check-label" for="noti_push2">Push</label>
                                                </div>
                                                <div class="form-check form-switch form-check-inline">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="noti_sms2" checked="">
                                                    <label class="form-check-label" for="noti_sms2">SMS</label>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-start py-4">
                                            <div>
                                                <h6>Tags</h6>
                                                <small class="text-muted">These are notificatios for when someone tags
                                                    you in comments, postof story.</small>
                                            </div>
                                            <div>
                                                <div class="form-check form-switch form-check-inline">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="noti_email3" checked="">
                                                    <label class="form-check-label" for="noti_email3">Email</label>
                                                </div>
                                                <div class="form-check form-switch form-check-inline">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="noti_push3" checked="">
                                                    <label class="form-check-label" for="noti_push3">Push</label>
                                                </div>
                                                <div class="form-check form-switch form-check-inline">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="noti_sms3">
                                                    <label class="form-check-label" for="noti_sms3">SMS</label>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-start py-4">
                                            <div>
                                                <h6>More activity about you</h6>
                                                <small class="text-muted">In semper feugiat commodo himenaeos diam
                                                    integer praesent cras</small>
                                            </div>
                                            <div>
                                                <div class="form-check form-switch form-check-inline">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="noti_email4">
                                                    <label class="form-check-label" for="noti_email4">Email</label>
                                                </div>
                                                <div class="form-check form-switch form-check-inline">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="noti_push4">
                                                    <label class="form-check-label" for="noti_push4">Push</label>
                                                </div>
                                                <div class="form-check form-switch form-check-inline">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="noti_sms4">
                                                    <label class="form-check-label" for="noti_sms4">SMS</label>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="FAQs" role="tabpanel" aria-labelledby="FAQs-tab">
                <div class="db-faqs">
                    <div class="row">
                        <div class="col-12">
                            <div class="lms-faqs mx-w-100 mt-0">
                                <div id="accordion">
                                    <div class="card">
                                        <div class="card-header" id="headingonsix">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse"
                                                        data-target="#collapsesix" aria-expanded="true"
                                                        aria-controls="collapsesix">Is there a free version of Rurera?
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapsesix" class="collapse show" aria-labelledby="headingsix"
                                             data-parent="#accordion">
                                            <div class="card-body">Yes, Free and paid both versions are available.</div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingTwo">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" data-toggle="collapse"
                                                        data-target="#collapseTwo" aria-expanded="false"
                                                        aria-controls="collapseTwo">How much does membership for student
                                                    cost ?
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                             data-parent="#accordion">
                                            <div class="card-body">It starts from 100$ per month and extended as per
                                                choice.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingseven">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" data-toggle="collapse"
                                                        data-target="#collapseseven" aria-expanded="false"
                                                        aria-controls="collapseseven">Which pricing plan is right for
                                                    me?
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseseven" class="collapse" aria-labelledby="headingseven"
                                             data-parent="#accordion">
                                            <div class="card-body">You can discuss with support and can have learning
                                                suggestions based on your skill set.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading8">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" data-toggle="collapse"
                                                        data-target="#collapse8" aria-expanded="false"
                                                        aria-controls="collapse8">Can i change my membership plan ?
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse8" class="collapse" aria-labelledby="heading8"
                                             data-parent="#accordion">
                                            <div class="card-body">You can make changes to your plan at any time by
                                                changing your plan type.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading9">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" data-toggle="collapse"
                                                        data-target="#collapse9" aria-expanded="false"
                                                        aria-controls="collapse9">What payment methods do you accept?
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse9" class="collapse" aria-labelledby="heading9"
                                             data-parent="#accordion">
                                            <div class="card-body">You can use paypal, skrill and bank transfer
                                                method.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <form action="/panel/financial/update_subscribe_plan" method="post" class="w-100">
        {{ csrf_field() }}
        <div class="col-12">


            <div class="lms-form-wrapper mb-50">

                <div class="lms-choose-plan d-flex mb-30">
                    <div class="lms-choose-field">
                        <strong class="choose-title d-block mb-20 font-24">Choose a plan</strong>
                        <p>Update Subscription duration</p>
                        <div class="lms-radio-select">
                            <ul class="lms-radio-btn-group d-inline-flex align-items-center">
                                <li>
                                    <input type="radio" id="month" value="1" data-discount="0"
                                           name="subscribe_for" checked="checked"/>
                                    <label class="lms-label" for="month">
                                        <span>01 month</span>
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" id="three_months" value="3" data-discount="5"
                                           name="subscribe_for"/>
                                    <label class="lms-label" for="three_months">
                                        <span>03 month <span>(5%)</span> </span>
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" id="six_months" value="6" data-discount="10"
                                           name="subscribe_for"/>
                                    <label class="lms-label" for="six_months">
                                        <span>06 month <span>(10%)</span> </span>
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" id="year" value="12" data-discount="20"
                                           name="subscribe_for"/>
                                    <label class="lms-label" for="year">
                                        <span>whole year <span>(20%)</span></span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block mt-50">
                    Update
                </button>
            </div>
        </div>
    </form>


    <div class="row">
        <div class="col-12 col-lg-12 mt-35">
            <button type="button" class="hide add-child btn btn-sm btn-border-white" data-toggle="modal"
                    data-target="#addChildModal">Add Child
            </button>

            <div class="bg-white noticeboard rounded-sm panel-shadow py-10 py-md-20 px-15 px-md-30">
                <h3 class="font-16 text-dark-blue font-weight-bold">Childs</h3>


                @if( !empty( $childs ) )
                @foreach($childs as $childObj)
                <div class="noticeboard-item py-15">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="js-noticeboard-title font-weight-500 text-secondary">
                                {{$childObj->full_name}}</h4>
                            <div class="font-12 text-gray mt-5">
                                <span class="mr-5">{{$childObj->email}}</span>
                                |
                                <span class="js-noticeboard-time ml-5">{{ dateTimeFormat($childObj->created_at,'j M Y | H:i') }}</span>
                            </div>
                        </div>

                        <div>
                            @php $package_id = 0; @endphp
                            @if(isset( $childObj->userSubscriptions->subscribe ) )
                            @php $package_id = $childObj->userSubscriptions->subscribe->id; @endphp
                            {{$childObj->userSubscriptions->subscribe->getTitleAttribute()}}
                            @endif
                            <button type="button" data-child="{{$childObj->id}}"
                                    class="js-switch-user btn btn-sm btn-border-white">Switch
                            </button>
                            <a href="/panel/parent/user/{{$childObj->id}}" data-child="{{$childObj->id}}"
                               class="btn btn-sm btn-border-white">Modify
                            </a>
                            <button type="button" data-child="{{$childObj->id}}"
                                    class="cancel-subscription btn btn-sm btn-border-white">
                                Cancel
                            </button>
                            <button data-package_id="{{$package_id}}" type="button" data-toggle="modal"
                                    data-target="#update-plan-modal" data-child="{{$childObj->id}}"
                                    class="update-package btn btn-sm btn-border-white">Update Package
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif

            </div>

        </div>

    </div>
</section>


<section class="mb-0 pt-70 pb-60">
    <div class="container">
        <div class="row">
            <form action="/panel/financial/pay-subscribes" method="post" class="w-100">
                {{ csrf_field() }}
                <div class="col-12">

                    <div class="lms-form-wrapper mb-50">
                        <div class="lms-choose-plan d-flex mb-30">
                            <div class="lms-choose-field hide">
                                <strong class="choose-title d-block mb-20 font-24">Add Child</strong>
                                <div class="lms-radio-select">
                                    <ul class="lms-radio-btn-group d-inline-flex align-items-center">
                                        <li>
                                            <input type="radio" id="month" value="1" data-discount="0"
                                                   name="subscribe_for" checked="checked"/>
                                            <label class="lms-label" for="month">
                                                <span>01 month</span>
                                            </label>
                                        </li>
                                        <li>
                                            <input type="radio" id="three_months" value="3" data-discount="5"
                                                   name="subscribe_for"/>
                                            <label class="lms-label" for="three_months">
                                                <span>03 month <span>(5%)</span> </span>
                                            </label>
                                        </li>
                                        <li>
                                            <input type="radio" id="six_months" value="6" data-discount="10"
                                                   name="subscribe_for"/>
                                            <label class="lms-label" for="six_months">
                                                <span>06 month <span>(10%)</span> </span>
                                            </label>
                                        </li>
                                        <li>
                                            <input type="radio" id="year" value="12" data-discount="20"
                                                   name="subscribe_for"/>
                                            <label class="lms-label" for="year">
                                                <span>whole year <span>(20%)</span></span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="lms-count-field">
                                <strong class="choose-title d-block mb-20 font-24">Choose number</strong>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button type="button" class="quantity-left-minus btn btn-number"
                                                data-type="minus" data-field="">
                                            <span class="icon-minus">−</span>
                                        </button>
                                    </span>
                                    <input type="text" id="quantity" name="quantity"
                                           class="form-control input-number" value="1" min="1"
                                           max="100">
                                    <span class="input-group-btn">
                                        <button type="button" class="quantity-right-plus btn btn-number"
                                                data-type="plus" data-field="">
                                            <span class="icon-plus">+</span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>


                        <div class="childs-block">
                            <div class="child-item lms-choose-plan-selected mt-10">
                                <div class="lms-jobs-form">
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-8">
                                            <div class="input-field">
                                                <input type="text" name="student_name[]"
                                                       placeholder="Enter your name..">
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-2 col-md-4">
                                            <div class="field-btn select-arrow">
                                                <button type="button" data-toggle="modal" class="package_label"
                                                        data-target="#choose-plan-modal">Package
                                                </button>
                                                <input type="hidden" name="package_id[]" class="package_id">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <br><br><br><br>
                        <div class="total-amount"></div>

                        <button type="submit" class="btn btn-primary btn-block mt-50">{{
                            trans('financial.purchase') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<div class="child-hidden-block hide">
    <div class="child-item lms-choose-plan-selected mt-10">
        <div class="lms-jobs-form">
            <div class="row">
                <div class="col-12 col-lg-4 col-md-8">
                    <div class="input-field">
                        <input type="text" name="student_name[]" placeholder="Enter your name..">
                    </div>
                </div>
                <div class="col-12 col-lg-2 col-md-4">
                    <div class="field-btn select-arrow">
                        <button type="button" data-toggle="modal" class="package_label"
                                data-target="#choose-plan-modal">Monthly
                        </button>
                        <input type="hidden" name="package_id[]" class="package_id">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade choose-plan-modal update-plan-model" id="update-plan-modal" tabindex="-1"
     aria-labelledby="update-plan-modalLabel" aria-hidden="true">
    <form action="/panel/financial/update-plan" method="post" class="w-100">
        {{ csrf_field() }}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <strong>Update plan</strong>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="subscribe-plan-holder">
                        <div class="container">
                            <div class="row">
                                <input type="hidden" name="child_id" class="update_plan_child">
                                @if(!empty($subscribes) and !$subscribes->isEmpty())
                                @foreach($subscribes as $subscribe)

                                <div class="col-lg-6 col-md-6 col-sm-12">

                                    <div class="select-plan">
                                        <input type="radio" class="choose-package update-package-{{$subscribe->id}}"
                                               data-label="{{ $subscribe->title }}"
                                               id="up-{{$subscribe->id}}" data-price="{{$subscribe->price}}"
                                               value="{{ $subscribe->id }}" name="package">
                                        <label for="up-{{$subscribe->id}}" data-label="{{ $subscribe->title }}">
                                            <div class="subscribe-plan position-relative d-flex flex-column rounded-lg py-25 px-20">
                                                        <span class="subscribe-icon mb-35">
                                                            <img src="../assets/default/svgs/box-color2.svg" alt="#">
                                                            <img src="../assets/default/svgs/box-white.svg"
                                                                 class="box-white-svg" alt="#">
                                                        </span>
                                                <h3 itemprop="title"
                                                    class="font-24 font-weight-500 text-dark-charcoal pt-20">{{
                                                    $subscribe->title }}</h3>
                                                <div class="d-flex align-items-start text-dark-charcoal mt-10">
                                                    <span itemprop="price" class="font-36 line-height-1">{{ addCurrencyToPrice($subscribe->price) }}</span>
                                                </div>
                                                <span class="plan-label d-block font-weight-500 pt-20">For Teachers</span>
                                                <ul class="plan-feature">
                                                    @php
                                                    $is_course_class = ($subscribe->is_courses == 0)? 'subscribe-no' :
                                                    '';
                                                    $is_timestables_class = ($subscribe->is_timestables == 0)?
                                                    'subscribe-no' : '';
                                                    $is_bookshelf_class = ($subscribe->is_bookshelf == 0)?
                                                    'subscribe-no' : '';
                                                    $is_sats_class = ($subscribe->is_sats == 0)? 'subscribe-no' : '';
                                                    $is_elevenplus_class = ($subscribe->is_elevenplus == 0)?
                                                    'subscribe-no' : '';
                                                    @endphp

                                                    <li itemprop="list" class="mt-15 {{$is_course_class}}"><span>All Courses Access</span>
                                                    </li>
                                                    <li itemprop="list" class="mt-15 {{$is_timestables_class}}"><span>Timestables</span>
                                                    </li>
                                                    <li itemprop="list" class="mt-15 {{$is_bookshelf_class}}"><span>Bookshelf</span>
                                                    </li>
                                                    <li itemprop="list" class="mt-15 {{$is_sats_class}}">
                                                        <span>SATs</span></li>
                                                    <li itemprop="list" class="mt-15 {{$is_elevenplus_class}}">
                                                        <span>11Plus</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                                <div class="col-12 mt-20">
                                    <button type="submit" class="select-plan-btn">Update Plan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade choose-plan-modal" id="choose-plan-modal" tabindex="-1"
     aria-labelledby="choose-plan-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Choose a plan</strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="subscribe-plan-holder">
                    <div class="container">
                        <div class="row">

                            @if(!empty($subscribes) and !$subscribes->isEmpty())
                            @foreach($subscribes as $subscribe)

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="select-plan">
                                    <input type="radio" class="choose-package" data-label="{{ $subscribe->title }}"
                                           id="{{$subscribe->id}}" data-price="{{$subscribe->price}}"
                                           value="{{ $subscribe->id }}" name="package">
                                    <label for="{{$subscribe->id}}" data-label="{{ $subscribe->title }}">
                                        <div class="subscribe-plan position-relative d-flex flex-column rounded-lg py-25 px-20">
                                                        <span class="subscribe-icon mb-35">
                                                            <img src="../assets/default/svgs/box-color2.svg" alt="#">
                                                            <img src="../assets/default/svgs/box-white.svg"
                                                                 class="box-white-svg" alt="#">
                                                        </span>
                                            <h3 itemprop="title"
                                                class="font-24 font-weight-500 text-dark-charcoal pt-20">{{
                                                $subscribe->title }}</h3>
                                            <div class="d-flex align-items-start text-dark-charcoal mt-10">
                                                <span itemprop="price" class="font-36 line-height-1">{{ addCurrencyToPrice($subscribe->price) }}</span>
                                            </div>
                                            <span class="plan-label d-block font-weight-500 pt-20">For Teachers</span>
                                            <ul class="plan-feature">
                                                @php
                                                $is_course_class = ($subscribe->is_courses == 0)? 'subscribe-no' :
                                                '';
                                                $is_timestables_class = ($subscribe->is_timestables == 0)?
                                                'subscribe-no' : '';
                                                $is_bookshelf_class = ($subscribe->is_bookshelf == 0)?
                                                'subscribe-no' : '';
                                                $is_sats_class = ($subscribe->is_sats == 0)? 'subscribe-no' : '';
                                                $is_elevenplus_class = ($subscribe->is_elevenplus == 0)?
                                                'subscribe-no' : '';
                                                @endphp

                                                <li itemprop="list" class="mt-15 {{$is_course_class}}"><span>All Courses Access</span>
                                                </li>
                                                <li itemprop="list" class="mt-15 {{$is_timestables_class}}"><span>Timestables</span>
                                                </li>
                                                <li itemprop="list" class="mt-15 {{$is_bookshelf_class}}"><span>Bookshelf</span>
                                                </li>
                                                <li itemprop="list" class="mt-15 {{$is_sats_class}}">
                                                    <span>SATs</span></li>
                                                <li itemprop="list" class="mt-15 {{$is_elevenplus_class}}">
                                                    <span>11Plus</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            <div class="col-12 mt-20">
                                <button type="button" class="select-plan-btn">Select Plan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addChildModal" tabindex="-1" aria-labelledby="addChildModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            <div class="modal-body">

                <form method="Post" action="panel/parent/create_student" class="create_student_form mt-35">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label class="input-label" for="full_name">Full Name:</label>
                        <input name="full_name" type="text" class="form-control rurera-req-field" id="full_name">
                    </div>

                    <div class="form-group">
                        <label class="input-label" for="email">Email :</label>
                        <input name="email" type="text" class="form-control rurera-req-field rurera-email-field"
                               id="email">
                    </div>
                    <div class="form-group">
                        <label class="input-label" for="password">Password :</label>
                        <input name="password" type="password" class="form-control rurera-req-field" id="password">
                    </div>


                    <button type="submit" class="btn btn-primary btn-block mt-20 submit-button">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts_bottom')
<script type="text/javascript">

    $(document).on('change', 'input[name="subscribe_for"]', function (e) {
        calculate_total_amount();
    });


    $(document).on('click', '.update-package', function (e) {
        var package_id = $(this).attr('data-package_id');
        var child_id = $(this).attr('data-child');
        $(".update_plan_child").val(child_id);
        $(".choose-package").attr('checked', false);
        $('label[for="up-' + package_id + '"]').click();
        $(".update-package-" + package_id).attr('checked', true);
    });


    $(document).on('click', '.package_label', function (e) {
        var current_index = $(".package_label").index($(this));
        $(this).closest('.field-btn').find('.package_id').attr('data-current_index', current_index);
        $(this).attr('data-index_no', current_index);
        $(".choose-plan-modal").attr('data-current_index', current_index);
    });
    $(document).on('click', '.quantity-right-plus', function (e) {
        var child_item_html = $(".child-hidden-block").html();
        $(".childs-block").append(child_item_html);
    });

    $(document).on('click', '.quantity-left-minus', function (e) {
        $('.childs-block .child-item:last-child').remove();
    });


    $(document).on('click', '.select-plan-btn', function (e) {
        var current_index = $(".choose-plan-modal").attr('data-current_index');
        var package_label = $(this).closest('.subscribe-plan-holder').find($('input[class="choose-package"]:checked')).attr('data-label');
        var package_price = $(this).closest('.subscribe-plan-holder').find($('input[class="choose-package"]:checked')).attr('data-price');
        $('.package_id[data-current_index="' + current_index + '"]').val($(this).closest('.subscribe-plan-holder').find($('input[class="choose-package"]:checked')).val());
        $('.package_id[data-current_index="' + current_index + '"]').attr('data-price', package_price);
        $('.package_label[data-index_no="' + current_index + '"]').html(package_label);
        $("#choose-plan-modal").modal('hide');
        calculate_total_amount();
    });

    function calculate_total_amount() {

        var total_amount = 0;
        var child_count = 0;
        $('.childs-block').find('.package_id').each(function (index_no) {
            if ($(this).attr('data-price') != 'undefined') {
                child_count++;
                var discount_percentage = 0;
                if (child_count > 1) {
                    discount_percentage = 5;
                }
                var current_price = parseInt($(this).attr('data-price'));
                var discount_amount = (parseFloat(current_price) * parseInt(discount_percentage)) / 100;
                current_price = (parseFloat(current_price) - parseFloat(discount_amount));
                total_amount = parseFloat(total_amount) + parseFloat(current_price);
            }
        });

        var discount_percentage = $('input[name="subscribe_for"]:checked').attr('data-discount');
        total_amount = (total_amount * $('input[name="subscribe_for"]:checked').val());

        var discount_amount = (parseFloat(total_amount) * parseInt(discount_percentage)) / 100;
        total_amount = (parseFloat(total_amount) - parseFloat(discount_amount));
        total_amount = parseFloat(total_amount).toFixed(2);

        $(".total-amount").html(total_amount);
    }


</script>
@endpush

@if(!empty($giftModal))
@push('scripts_bottom2')
<script>
    (function () {
        "use strict";

        handleLimitedAccountModal('{!! $giftModal !!}', 40)
    })(jQuery)
</script>

@endpush
@endif
