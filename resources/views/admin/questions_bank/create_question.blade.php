@extends('admin.layouts.app')
@php
$toolbar_tools  = toolbar_tools();
$element_properties_meta    = element_properties_meta($chapters);
$tabs_options    = tabs_options();
$rand_id = rand(999,99999);

@endphp


@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.css">
<link rel="stylesheet" href="/assets/default/css/quiz-layout.css?ver={{$rand_id}}">
<link rel="stylesheet" href="/assets/default/css/quiz-create.css?ver={{$rand_id}}">
<link href="/assets/default/css/jquery-ui/jquery-ui.min.css" rel="stylesheet">
<link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
<script src="/assets/default/js/admin/jquery.min.js"></script>
<script src="/assets/default/js/admin/sticky-sidebar.js?ver={{$rand_id}}"></script>
<script src="/assets/default/js/admin/question-create.js?ver={{$rand_id}}"></script>
<link rel="stylesheet" href="/assets/default/vendors/bootstrap-tagsinput/bootstrap-tagsinput.min.css">
<style>
    .droppable_area {
        width: 150px;
        height: 50px;
        border: 1px solid #efefef;
        display: inline-block;
    }
    .image-field, .image-field-box {
        width: fit-content;
    }
    .image-field img, .containment-wrapper {
        position: relative !important;
    }
    .image-field-box {
        position: absolute !important;
    }
    /*.draggable3 {
        width: 150px;
    }*/
    .spreadsheet-area {
        border: 1px solid #efefef;
        padding: 10px;
        background: #fff;
        height: 200px;
    }
    .question-layout-data .rureraform-element{
        outline: none !important;
    }
    .navbar-bg {
        display: none;
    }
    nav.navbar.navbar-expand-lg.main-navbar {
        display: none;
    }
	.modal-open .modal{
		z-index: 99999;
	}
</style>
@endpush

@php $save_type = isset( $questionObj->id )? 'update_question' : 'store_question'; @endphp

@section('content')

<section class="section form-class" data-question_save_type="{{$save_type}}">


    <div class="section-body lms-quiz-create">
        
        <div class="row">
		<div class="col-12 col-md-12 col-lg-12">
        
                        <ul class="col-10 col-md-10 col-lg-10 admin-rurera-tabs nav nav-pills" id="assignment_tabs" role="tablist">
                            <li class="nav-item">
                               <a class="nav-link active" id="question_properties-tab" data-toggle="tab" href="#question_properties" role="tab"
                                  aria-controls="question_properties" aria-selected="false"><span class="tab-title">Question Properties</span></a>
                           </li>
                            <li class="nav-item">
                                <a class="nav-link" id="question_design-tab" data-toggle="tab" href="#question_design" role="tab"
                                   aria-controls="question_design" aria-selected="true"><span class="tab-title">Question Design</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="glossary_solution-tab" data-toggle="tab"
                                   href="#glossary_solution" role="tab"
                                   aria-controls="glossary_solution" aria-selected="true"><span class="tab-title">Glossary & Solution</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="review_required_tab-tab" data-toggle="tab"
                                   href="#review_required_tab" role="tab"
                                   aria-controls="review_required_tab" aria-selected="true"><span class="tab-title">Comments for Reviewer</span></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="question_preview-tab" data-toggle="tab"
                                   href="#question_preview" role="tab"
                                   aria-controls="question_design" aria-selected="true"><span class="tab-title">Question Preview</span></a>
                            </li>
                           
                        </ul>
			</div>
			</div>


        <div class="row">


            <div class="col-12 col-md-12">


                <div class="card">
                    <div class="card-body">


                        <div class="tab-content" id="myTabContent2">

                            <div class="patterns-modal">
							 
                              <button type="button" class="btn btn-primary rurera-hide" data-toggle="modal" data-target=".bd-example-modal-lg">Button</button>
                              <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h3>
                                        All Question Types
                                        <span>We have a great range of question types to choose from.</span>
                                      </h3>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="row">
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                          <div class="media-holder">
                                            <a href="#">
                                              <figure>
                                                <img src="/assets/default/img/multiple-choice.png" alt="feature image" height="275" width="530">
                                              </figure>
                                            </a>
                                            <div class="media-title">
                                              <h4><a href="#">Multiple Choice</a></h4>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                          <div class="media-holder">
                                            <figure>
                                              <img src="/assets/default/img/multiple-answers.png" alt="feature image" height="275" width="530">
                                            </figure>
                                            <div class="media-title">
                                              <h4><a href="#">Multiple Answers</a></h4>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                          <div class="media-holder">
                                            <figure>
                                              <img src="/assets/default/img/true-or-false.png" alt="feature image" height="275" width="530">
                                            </figure>
                                            <div class="media-title">
                                              <h4><a href="#">True or False</a></h4>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="media-holder">
                                              <figure>
                                                <img src="/assets/default/img/fill-in-the-blank.png" alt="feature image" height="275" width="530">
                                              </figure>
                                              <div class="media-title">
                                                <h4><a href="#">Fill in the blanks</a></h4>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="media-holder">
                                              <figure>
                                                <img src="/assets/default/img/easy-type.png" alt="feature image" height="275" width="530">
                                              </figure>
                                              <div class="media-title">
                                                <h4><a href="#">Essay Type</a></h4>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="media-holder">
                                              <figure>
                                                <img src="/assets/default/img/matching.png" alt="feature image" height="275" width="530">
                                              </figure>
                                              <div class="media-title">
                                                <h4><a href="#">Matching</a></h4>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="media-holder">
                                              <figure>
                                                <img src="/assets/default/img/hotspot.png" alt="feature image" height="275" width="530">
                                              </figure>
                                              <div class="media-title">
                                                <h4><a href="#">Hotspot</a></h4>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="media-holder">
                                              <figure>
                                                <img src="/assets/default/img/drop-down.png" alt="feature image" height="275" width="530">
                                              </figure>
                                              <div class="media-title">
                                                <h4><a href="#">Drop-down</a></h4>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="media-holder">
                                              <figure>
                                                <img src="/assets/default/img/type-in.png" alt="feature image" height="275" width="530">
                                              </figure>
                                              <div class="media-title">
                                                <h4><a href="#">Type-In</a></h4>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="media-holder">
                                              <figure>
                                                <img src="/assets/default/img/order-list.png" alt="feature image" height="275" width="530">
                                              </figure>
                                              <div class="media-title">
                                                <h4><a href="#">Order List</a></h4>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="media-holder">
                                              <figure>
                                                <img src="/assets/default/img/note.png" alt="feature image" height="275" width="530">
                                              </figure>
                                              <div class="media-title">
                                                <h4><a href="#">Note</a></h4>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="media-holder">
                                              <figure>
                                                <img src="/assets/default/img/document.png" alt="feature image" height="275" width="530">
                                              </figure>
                                              <div class="media-title">
                                                <h4><a href="#">Document</a></h4>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="media-holder">
                                              <figure>
                                                <img src="/assets/default/img/audio-response.png" alt="feature image" height="275" width="530">
                                              </figure>
                                              <div class="media-title">
                                                <h4><a href="#">Upload Audio/Video</a></h4>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="media-holder">
                                              <figure>
                                                <img src="/assets/default/img/video-response.png" alt="feature image" height="275" width="530">
                                              </figure>
                                              <div class="media-title">
                                                <h4><a href="#">Record Audio/Video</a></h4>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="media-holder">
                                              <figure>
                                                <img src="/assets/default/img/upload.png" alt="feature image" height="275" width="530">
                                              </figure>
                                              <div class="media-title">
                                                <h4><a href="#">Upload</a></h4>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="media-holder">
                                              <figure>
                                                <img src="/assets/default/img/comprehension.png" alt="feature image" height="275" width="530">
                                              </figure>
                                              <div class="media-title">
                                                <h4><a href="#">Comprehension</a></h4>
                                              </div>
                                            </div>
                                          </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="tab-pane mt-3 fade" id="question_design" role="tabpanel"
                                 aria-labelledby="question_design-tab">
                                <div class="row">

                                    <div class="col-7 col-md-7">
                                        <div class="hap-container">
                                            <div class="hap-content">
                                                <div class="hap-content-area">
                                                    <div id="global-message-container">
                                                    </div>
                                                    <div class="hap-content-box">
                                                        <script>rureraform_gettingstarted_enable = "off";</script>
                                                        <div class="wrap rureraform-admin rureraform-admin-editor">
                                                            <div class="rureraform-form-editor">
                                                                <div class="rureraform-toolbars">
                                                                    <div class="rureraform-header"></div>
                                                                    <div class="rureraform-pages-bar">
                                                                        <ul class="rureraform-pages-bar-items hide">
                                                                            <li class="rureraform-pages-bar-item"
                                                                                data-id="1"
                                                                                data-name="Page"><label
                                                                                        onclick="return rureraform_pages_activate(this);">Page</label><span><a
                                                                                            href="#" data-type="page"
                                                                                            onclick="return rureraform_properties_open(this);"><i
                                                                                                class="fas fa-cog"></i></a><a
                                                                                            href="#"
                                                                                            class="rureraform-pages-bar-item-delete rureraform-pages-bar-item-delete-disabled"
                                                                                            onclick="return rureraform_pages_delete(this);"><i
                                                                                                class="fas fa-trash-alt"></i></a></span>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="rureraform-toolbar">
                                                                        <ul class="rureraform-toolbar-list">
                                                                            @php
                                                                            foreach ($toolbar_tools as $key => $value) {
																				
                                                                            if (array_key_exists('options', $value)) {
																				$options_elements = isset( $value['options_elements'] )? $value['options_elements'] : array();
																				
                                                                            echo '
                                                                            <li class="rureraform-toolbar-tool-' . esc_html($value['type']) . '"
                                                                                class="rureraform-toolbar-list-options"
                                                                                data-type="' . esc_html($key) . '"
                                                                                data-option="2"><a
                                                                                        href="#"
                                                                                        data-title="' . esc_html($value['title']) . '"><i
                                                                                            class="' . esc_html($value['icon']) . '"></i></a>
                                                                                <ul class="' . esc_html($key) . '">';
                                                                                    foreach ($value['options'] as
                                                                                    $option_key =>
                                                                                    $option_value) {
																						
																					$data_options_elements = isset( $options_elements[$option_key] )? $options_elements[$option_key] : '';

                                                                                    echo '
                                                                                    <li data-type="' . esc_html($key) . '"
                                                                                        data-option="' . esc_html($option_key) . '" 
                                                                                        data-elements="' . esc_html($data_options_elements) . '"
                                                                                        ><a href="#"
                                                                                                    data-title="' . esc_html($value['title']) . '">'
                                                                                            . esc_html($option_value) .
                                                                                            '</a></li>
                                                                                    ';
                                                                                    }
                                                                                    echo '
                                                                                </ul>
                                                                            </li>
                                                                            ';
                                                                            } else {
                                                                            $classes = isset( $value['classes'] )? $value['classes'] : '';
																			
																			$icon = '<i class="' . esc_html($value['icon']) . '"></i>';
																			if( isset( $value['icon_type'] ) && $value['icon_type'] == 'svg'){
																				$icon = '<img src="/assets/admin/img/tools-elements/' . esc_html($value['icon']) . '" width="15">';
																			}
																			
																			
                                                                            echo '
                                                                            <li class="rureraform-toolbar-tool-' . esc_html($value['type']) . ' '.$classes.'"
                                                                                data-title="' . esc_html($value['title']) . '" data-type="' . esc_html($key) . '"><a
                                                                                        href="#"
                                                                                        title="' . esc_html($value['title']) . '">'.$icon.'</a>
                                                                            </li>
                                                                            ';
                                                                            }
                                                                            }
                                                                            @endphp

                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="rureraform-builder">
                                                                    <div class="rureraform-form-global-style"></div>
                                                                    <div id="rureraform-form-1"
                                                                         class="rureraform-form rureraform-elements"
                                                                         _data-parent="1" _data-parent-col="0"></div>
                                                                </div>
                                                            </div>
                                                            <iframe data-loading="false" id="rureraform-import-style-iframe"
                                                                    name="rureraform-import-style-iframe" src="about:blank"
                                                                    onload="rureraform_stylemanager_imported(this);"></iframe>
                                                            <form id="rureraform-import-style-form"
                                                                  enctype="multipart/form-data"
                                                                  method="post" target="rureraform-import-style-iframe"
                                                                  action="http://baz.com/greenform/?page=rureraform&rureraform-action=import-style">
                                                                <input id="rureraform-import-style-file" type="file"
                                                                       accept=".txt, .zip"
                                                                       name="rureraform-file"
                                                                       onchange="jQuery('#rureraform-import-style-iframe').attr('data-loading', 'true'); jQuery('#rureraform-import-style-form').submit();">
                                                            </form>
                                                            <div class="rureraform-admin-popup-overlay"
                                                                 id="rureraform-element-properties-overlay"></div>

                                                            <div class="rureraform-fa-selector-overlay"></div>
                                                            <div class="rureraform-fa-selector">
                                                                <div class="rureraform-fa-selector-inner">
                                                                    <div class="rureraform-fa-selector-header">
                                                                        <a href="#" title="Close"
                                                                           onclick="return rureraform_fa_selector_close();"><i
                                                                                    class="fas fa-times"></i></a>
                                                                        <input type="text" placeholder="Search...">
                                                                    </div>
                                                                    <div class="rureraform-fa-selector-content">
                                                                                                                        <span title="No icon"
                                                                                                                              onclick="rureraform_fa_selector_set(this);"><i
                                                                                                                                    class=""></i></span><span
                                                                                title="Star"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-star"></i></span><span
                                                                                title="Star O"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-star-o"></i></span><span
                                                                                title="Check"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-check"></i></span><span
                                                                                title="Close"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-close"></i></span><span
                                                                                title="Lock"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-lock"></i></span><span
                                                                                title="Picture O"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-picture-o"></i></span><span
                                                                                title="Upload"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-upload"></i></span><span
                                                                                title="Download"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-download"></i></span><span
                                                                                title="Calendar"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-calendar"></i></span><span
                                                                                title="Clock O"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-clock-o"></i></span><span
                                                                                title="Chevron Left"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-chevron-left"></i></span><span
                                                                                title="Chevron Right"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-chevron-right"></i></span><span
                                                                                title="Phone"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-phone"></i></span><span
                                                                                title="Envelope"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-envelope"></i></span><span
                                                                                title="Envelope O"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-envelope-o"></i></span><span
                                                                                title="Pencil"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-pencil"></i></span><span
                                                                                title="Angle Double Left"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-angle-double-left"></i></span><span
                                                                                title="Angle Double Right"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-angle-double-right"></i></span><span
                                                                                title="Spinner"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-spinner"></i></span><span
                                                                                title="Smile O"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-smile-o"></i></span><span
                                                                                title="Frown O"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-frown-o"></i></span><span
                                                                                title="Meh O"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-meh-o"></i></span><span
                                                                                title="Send"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-send"></i></span><span
                                                                                title="Send O"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-send-o"></i></span><span
                                                                                title="User"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-user"></i></span><span
                                                                                title="User O"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-user-o"></i></span><span
                                                                                title="Building O"
                                                                                onclick="rureraform_fa_selector_set(this);"><i
                                                                                    class="rureraform-fa rureraform-fa-building-o"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div id="rureraform-global-message"></div>
                                                            <div class="rureraform-dialog-overlay"
                                                                 id="rureraform-dialog-overlay"></div>
                                                            <div class="rureraform-dialog" id="rureraform-dialog">
                                                                <div class="rureraform-dialog-inner">
                                                                    <div class="rureraform-dialog-title">
                                                                        <a href="#" title="Close"
                                                                           onclick="return rureraform_dialog_close();"><i
                                                                                    class="fas fa-times"></i></a>
                                                                        <h3><i class="fas fa-cog"></i><label></label>
                                                                        </h3>
                                                                    </div>
                                                                    <div class="rureraform-dialog-content">
                                                                        <div class="rureraform-dialog-content-html">
                                                                        </div>
                                                                    </div>
                                                                    <div class="rureraform-dialog-buttons">
                                                                        <a class="rureraform-dialog-button rureraform-dialog-button-ok"
                                                                           href="#"
                                                                           onclick="return false;"><i
                                                                                    class="fas fa-check"></i><label></label></a>
                                                                        <a class="rureraform-dialog-button rureraform-dialog-button-cancel"
                                                                           href="#" onclick="return false;"><i
                                                                                    class="fas fa-times"></i><label></label></a>
                                                                    </div>
                                                                    <div class="rureraform-dialog-loading"><i
                                                                                class="fas fa-spinner fa-spin"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" id="rureraform-id" value="3"/>
                                                            <script>
                                                                var rureraform_webfonts = ["ABeeZee", "Abel", "Abhaya Libre", "Abril Fatface", "Aclonica", "Acme", "Actor", "Adamina", "Advent Pro", "Aguafina Script", "Akronim", "Aladin", "Alata", "Alatsi", "Aldrich", "Alef", "Alegreya", "Alegreya Sans", "Alegreya Sans SC", "Alegreya SC", "Aleo", "Alex Brush", "Alfa Slab One", "Alice", "Alike", "Alike Angular", "Allan", "Allerta", "Allerta Stencil", "Allura", "Almarai", "Almendra", "Almendra Display", "Almendra SC", "Amarante", "Amaranth", "Amatic SC", "Amethysta", "Amiko", "Amiri", "Amita", "Anaheim", "Andada", "Andika", "Andika New Basic", "Angkor", "Annie Use Your Telescope", "Anonymous Pro", "Antic", "Antic Didone", "Antic Slab", "Anton", "Arapey", "Arbutus", "Arbutus Slab", "Architects Daughter", "Archivo", "Archivo Black", "Archivo Narrow", "Aref Ruqaa", "Arima Madurai", "Arimo", "Arizonia", "Armata", "Arsenal", "Artifika", "Arvo", "Arya", "Asap", "Asap Condensed", "Asar", "Asset", "Assistant", "Astloch", "Asul", "Athiti", "Atma", "Atomic Age", "Aubrey", "Audiowide", "Autour One", "Average", "Average Sans", "Averia Gruesa Libre", "Averia Libre", "Averia Sans Libre", "Averia Serif Libre", "B612", "B612 Mono", "Bad Script", "Bahiana", "Bahianita", "Bai Jamjuree", "Baloo 2", "Baloo Bhai 2", "Baloo Bhaina 2", "Baloo Chettan 2", "Baloo Da 2", "Baloo Paaji 2", "Baloo Tamma 2", "Baloo Tammudu 2", "Baloo Thambi 2", "Balsamiq Sans", "Balthazar", "Bangers", "Barlow", "Barlow Condensed", "Barlow Semi Condensed", "Barriecito", "Barrio", "Basic", "Baskervville", "Battambang", "Baumans", "Bayon", "Be Vietnam", "Bebas Neue", "Belgrano", "Bellefair", "Belleza", "Bellota", "Bellota Text", "BenchNine", "Bentham", "Berkshire Swash", "Beth Ellen", "Bevan", "Big Shoulders Display", "Big Shoulders Inline Display", "Big Shoulders Inline Text", "Big Shoulders Stencil Display", "Big Shoulders Stencil Text", "Big Shoulders Text", "Bigelow Rules", "Bigshot One", "Bilbo", "Bilbo Swash Caps", "BioRhyme", "BioRhyme Expanded", "Biryani", "Bitter", "Black And White Picture", "Black Han Sans", "Black Ops One", "Blinker", "Bodoni Moda", "Bokor", "Bonbon", "Boogaloo", "Bowlby One", "Bowlby One SC", "Brawler", "Bree Serif", "Bubblegum Sans", "Bubbler One", "Buda", "Buenard", "Bungee", "Bungee Hairline", "Bungee Inline", "Bungee Outline", "Bungee Shade", "Butcherman", "Butterfly Kids", "Cabin", "Cabin Condensed", "Cabin Sketch", "Caesar Dressing", "Cagliostro", "Cairo", "Caladea", "Calistoga", "Calligraffitti", "Cambay", "Cambo", "Candal", "Cantarell", "Cantata One", "Cantora One", "Capriola", "Cardo", "Carme", "Carrois Gothic", "Carrois Gothic SC", "Carter One", "Castoro", "Catamaran", "Caudex", "Caveat", "Caveat Brush", "Cedarville Cursive", "Ceviche One", "Chakra Petch", "Changa", "Changa One", "Chango", "Charm", "Charmonman", "Chathura", "Chau Philomene One", "Chela One", "Chelsea Market", "Chenla", "Cherry Cream Soda", "Cherry Swash", "Chewy", "Chicle", "Chilanka", "Chivo", "Chonburi", "Cinzel", "Cinzel Decorative", "Clicker Script", "Coda", "Coda Caption", "Codystar", "Coiny", "Combo", "Comfortaa", "Comic Neue", "Coming Soon", "Commissioner", "Concert One", "Condiment", "Content", "Contrail One", "Convergence", "Cookie", "Copse", "Corben", "Cormorant", "Cormorant Garamond", "Cormorant Infant", "Cormorant SC", "Cormorant Unicase", "Cormorant Upright", "Courgette", "Courier Prime", "Cousine", "Coustard", "Covered By Your Grace", "Crafty Girls", "Creepster", "Crete Round", "Crimson Pro", "Crimson Text", "Croissant One", "Crushed", "Cuprum", "Cute Font", "Cutive", "Cutive Mono", "Damion", "Dancing Script", "Dangrek", "Darker Grotesque", "David Libre", "Dawning of a New Day", "Days One", "Dekko", "Delius", "Delius Swash Caps", "Delius Unicase", "Della Respira", "Denk One", "Devonshire", "Dhurjati", "Didact Gothic", "Diplomata", "Diplomata SC", "DM Mono", "DM Sans", "DM Serif Display", "DM Serif Text", "Do Hyeon", "Dokdo", "Domine", "Donegal One", "Doppio One", "Dorsa", "Dosis", "Dr Sugiyama", "Duru Sans", "Dynalight", "Eagle Lake", "East Sea Dokdo", "Eater", "EB Garamond", "Economica", "Eczar", "El Messiri", "Electrolize", "Elsie", "Elsie Swash Caps", "Emblema One", "Emilys Candy", "Encode Sans", "Encode Sans Condensed", "Encode Sans Expanded", "Encode Sans Semi Condensed", "Encode Sans Semi Expanded", "Engagement", "Englebert", "Enriqueta", "Epilogue", "Erica One", "Esteban", "Euphoria Script", "Ewert", "Exo", "Exo 2", "Expletus Sans", "Fahkwang", "Fanwood Text", "Farro", "Farsan", "Fascinate", "Fascinate Inline", "Faster One", "Fasthand", "Fauna One", "Faustina", "Federant", "Federo", "Felipa", "Fenix", "Finger Paint", "Fira Code", "Fira Mono", "Fira Sans", "Fira Sans Condensed", "Fira Sans Extra Condensed", "Fjalla One", "Fjord One", "Flamenco", "Flavors", "Fondamento", "Fontdiner Swanky", "Forum", "Francois One", "Frank Ruhl Libre", "Fraunces", "Freckle Face", "Fredericka the Great", "Fredoka One", "Freehand", "Fresca", "Frijole", "Fruktur", "Fugaz One", "Gabriela", "Gaegu", "Gafata", "Galada", "Galdeano", "Galindo", "Gamja Flower", "Gayathri", "Gelasio", "Gentium Basic", "Gentium Book Basic", "Geo", "Geostar", "Geostar Fill", "Germania One", "GFS Didot", "GFS Neohellenic", "Gidugu", "Gilda Display", "Girassol", "Give You Glory", "Glass Antiqua", "Glegoo", "Gloria Hallelujah", "Goblin One", "Gochi Hand", "Goldman", "Gorditas", "Gothic A1", "Gotu", "Goudy Bookletter 1911", "Graduate", "Grand Hotel", "Grandstander", "Gravitas One", "Great Vibes", "Grenze", "Grenze Gotisch", "Griffy", "Gruppo", "Gudea", "Gugi", "Gupter", "Gurajada", "Habibi", "Hachi Maru Pop", "Halant", "Hammersmith One", "Hanalei", "Hanalei Fill", "Handlee", "Hanuman", "Happy Monkey", "Harmattan", "Headland One", "Heebo", "Henny Penny", "Hepta Slab", "Herr Von Muellerhoff", "Hi Melody", "Hind", "Hind Guntur", "Hind Madurai", "Hind Siliguri", "Hind Vadodara", "Holtwood One SC", "Homemade Apple", "Homenaje", "Ibarra Real Nova", "IBM Plex Mono", "IBM Plex Sans", "IBM Plex Sans Condensed", "IBM Plex Serif", "Iceberg", "Iceland", "IM Fell Double Pica", "IM Fell Double Pica SC", "IM Fell DW Pica", "IM Fell DW Pica SC", "IM Fell English", "IM Fell English SC", "IM Fell French Canon", "IM Fell French Canon SC", "IM Fell Great Primer", "IM Fell Great Primer SC", "Imbue", "Imprima", "Inconsolata", "Inder", "Indie Flower", "Inika", "Inknut Antiqua", "Inria Sans", "Inria Serif", "Inter", "Irish Grover", "Istok Web", "Italiana", "Italianno", "Itim", "Jacques Francois", "Jacques Francois Shadow", "Jaldi", "JetBrains Mono", "Jim Nightshade", "Jockey One", "Jolly Lodger", "Jomhuria", "Jomolhari", "Josefin Sans", "Josefin Slab", "Jost", "Joti One", "Jua", "Judson", "Julee", "Julius Sans One", "Junge", "Jura", "Just Another Hand", "Just Me Again Down Here", "K2D", "Kadwa", "Kalam", "Kameron", "Kanit", "Kantumruy", "Karla", "Karma", "Katibeh", "Kaushan Script", "Kavivanar", "Kavoon", "Kdam Thmor", "Keania One", "Kelly Slab", "Kenia", "Khand", "Khmer", "Khula", "Kirang Haerang", "Kite One", "Knewave", "Kodchasan", "KoHo", "Kosugi", "Kosugi Maru", "Kotta One", "Koulen", "Kranky", "Kreon", "Kristi", "Krona One", "Krub", "Kufam", "Kulim Park", "Kumar One", "Kumar One Outline", "Kumbh Sans", "Kurale", "La Belle Aurore", "Lacquer", "Laila", "Lakki Reddy", "Lalezar", "Lancelot", "Langar", "Lateef", "Lato", "League Script", "Leckerli One", "Ledger", "Lekton", "Lemon", "Lemonada", "Lexend Deca", "Lexend Exa", "Lexend Giga", "Lexend Mega", "Lexend Peta", "Lexend Tera", "Lexend Zetta", "Libre Barcode 128", "Libre Barcode 128 Text", "Libre Barcode 39", "Libre Barcode 39 Extended", "Libre Barcode 39 Extended Text", "Libre Barcode 39 Text", "Libre Barcode EAN13 Text", "Libre Baskerville", "Libre Caslon Display", "Libre Caslon Text", "Libre Franklin", "Life Savers", "Lilita One", "Lily Script One", "Limelight", "Linden Hill", "Literata", "Liu Jian Mao Cao", "Livvic", "Lobster", "Lobster Two", "Londrina Outline", "Londrina Shadow", "Londrina Sketch", "Londrina Solid", "Long Cang", "Lora", "Love Ya Like A Sister", "Loved by the King", "Lovers Quarrel", "Luckiest Guy", "Lusitana", "Lustria", "M PLUS 1p", "M PLUS Rounded 1c", "Ma Shan Zheng", "Macondo", "Macondo Swash Caps", "Mada", "Magra", "Maiden Orange", "Maitree", "Major Mono Display", "Mako", "Mali", "Mallanna", "Mandali", "Manjari", "Manrope", "Mansalva", "Manuale", "Marcellus", "Marcellus SC", "Marck Script", "Margarine", "Markazi Text", "Marko One", "Marmelad", "Martel", "Martel Sans", "Marvel", "Mate", "Mate SC", "Maven Pro", "McLaren", "Meddon", "MedievalSharp", "Medula One", "Meera Inimai", "Megrim", "Meie Script", "Merienda", "Merienda One", "Merriweather", "Merriweather Sans", "Metal", "Metal Mania", "Metamorphous", "Metrophobic", "Michroma", "Milonga", "Miltonian", "Miltonian Tattoo", "Mina", "Miniver", "Miriam Libre", "Mirza", "Miss Fajardose", "Mitr", "Modak", "Modern Antiqua", "Mogra", "Molengo", "Molle", "Monda", "Monofett", "Monoton", "Monsieur La Doulaise", "Montaga", "Montez", "Montserrat", "Montserrat Alternates", "Montserrat Subrayada", "Moul", "Moulpali", "Mountains of Christmas", "Mouse Memoirs", "Mr Bedfort", "Mr Dafoe", "Mr De Haviland", "Mrs Saint Delafield", "Mrs Sheppards", "Mukta", "Mukta Mahee", "Mukta Malar", "Mukta Vaani", "Mulish", "MuseoModerno", "Mystery Quest", "Nanum Brush Script", "Nanum Gothic", "Nanum Gothic Coding", "Nanum Myeongjo", "Nanum Pen Script", "Nerko One", "Neucha", "Neuton", "New Rocker", "News Cycle", "Niconne", "Niramit", "Nixie One", "Nobile", "Nokora", "Norican", "Nosifer", "Notable", "Nothing You Could Do", "Noticia Text", "Noto Sans", "Noto Sans HK", "Noto Sans JP", "Noto Sans KR", "Noto Sans SC", "Noto Sans TC", "Noto Serif", "Noto Serif JP", "Noto Serif KR", "Noto Serif SC", "Noto Serif TC", "Nova Cut", "Nova Flat", "Nova Mono", "Nova Oval", "Nova Round", "Nova Script", "Nova Slim", "Nova Square", "NTR", "Numans", "Nunito", "Nunito Sans", "Odibee Sans", "Odor Mean Chey", "Offside", "Old Standard TT", "Oldenburg", "Oleo Script", "Oleo Script Swash Caps", "Open Sans", "Open Sans Condensed", "Oranienbaum", "Orbitron", "Oregano", "Orienta", "Original Surfer", "Oswald", "Over the Rainbow", "Overlock", "Overlock SC", "Overpass", "Overpass Mono", "Ovo", "Oxanium", "Oxygen", "Oxygen Mono", "Pacifico", "Padauk", "Palanquin", "Palanquin Dark", "Pangolin", "Paprika", "Parisienne", "Passero One", "Passion One", "Pathway Gothic One", "Patrick Hand", "Patrick Hand SC", "Pattaya", "Patua One", "Pavanam", "Paytone One", "Peddana", "Peralta", "Permanent Marker", "Petit Formal Script", "Petrona", "Philosopher", "Piazzolla", "Piedra", "Pinyon Script", "Pirata One", "Plaster", "Play", "Playball", "Playfair Display", "Playfair Display SC", "Podkova", "Poiret One", "Poller One", "Poly", "Pompiere", "Pontano Sans", "Poor Story", "Poppins", "Port Lligat Sans", "Port Lligat Slab", "Potta One", "Pragati Narrow", "Prata", "Preahvihear", "Press Start 2P", "Pridi", "Princess Sofia", "Prociono", "Prompt", "Prosto One", "Proza Libre", "PT Mono", "PT Sans", "PT Sans Caption", "PT Sans Narrow", "PT Serif", "PT Serif Caption", "Public Sans", "Puritan", "Purple Purse", "Quando", "Quantico", "Quattrocento", "Quattrocento Sans", "Questrial", "Quicksand", "Quintessential", "Qwigley", "Racing Sans One", "Radley", "Rajdhani", "Rakkas", "Raleway", "Raleway Dots", "Ramabhadra", "Ramaraja", "Rambla", "Rammetto One", "Ranchers", "Rancho", "Ranga", "Rasa", "Rationale", "Ravi Prakash", "Recursive", "Red Hat Display", "Red Hat Text", "Red Rose", "Redressed", "Reem Kufi", "Reenie Beanie", "Revalia", "Rhodium Libre", "Ribeye", "Ribeye Marrow", "Righteous", "Risque", "Roboto", "Roboto Condensed", "Roboto Mono", "Roboto Slab", "Rochester", "Rock Salt", "Rokkitt", "Romanesco", "Ropa Sans", "Rosario", "Rosarivo", "Rouge Script", "Rowdies", "Rozha One", "Rubik", "Rubik Mono One", "Ruda", "Rufina", "Ruge Boogie", "Ruluko", "Rum Raisin", "Ruslan Display", "Russo One", "Ruthie", "Rye", "Sacramento", "Sahitya", "Sail", "Saira", "Saira Condensed", "Saira Extra Condensed", "Saira Semi Condensed", "Saira Stencil One", "Salsa", "Sanchez", "Sancreek", "Sansita", "Sansita Swashed", "Sarabun", "Sarala", "Sarina", "Sarpanch", "Satisfy", "Sawarabi Gothic", "Sawarabi Mincho", "Scada", "Scheherazade", "Schoolbell", "Scope One", "Seaweed Script", "Secular One", "Sedgwick Ave", "Sedgwick Ave Display", "Sen", "Sevillana", "Seymour One", "Shadows Into Light", "Shadows Into Light Two", "Shanti", "Share", "Share Tech", "Share Tech Mono", "Shojumaru", "Short Stack", "Shrikhand", "Siemreap", "Sigmar One", "Signika", "Signika Negative", "Simonetta", "Single Day", "Sintony", "Sirin Stencil", "Six Caps", "Skranji", "Slabo 13px", "Slabo 27px", "Slackey", "Smokum", "Smythe", "Sniglet", "Snippet", "Snowburst One", "Sofadi One", "Sofia", "Solway", "Song Myung", "Sonsie One", "Sora", "Sorts Mill Goudy", "Source Code Pro", "Source Sans Pro", "Source Serif Pro", "Space Grotesk", "Space Mono", "Spartan", "Special Elite", "Spectral", "Spectral SC", "Spicy Rice", "Spinnaker", "Spirax", "Squada One", "Sree Krushnadevaraya", "Sriracha", "Srisakdi", "Staatliches", "Stalemate", "Stalinist One", "Stardos Stencil", "Stint Ultra Condensed", "Stint Ultra Expanded", "Stoke", "Strait", "Stylish", "Sue Ellen Francisco", "Suez One", "Sulphur Point", "Sumana", "Sunflower", "Sunshiney", "Supermercado One", "Sura", "Suranna", "Suravaram", "Suwannaphum", "Swanky and Moo Moo", "Syncopate", "Syne", "Syne Mono", "Syne Tactile", "Tajawal", "Tangerine", "Taprom", "Tauri", "Taviraj", "Teko", "Telex", "Tenali Ramakrishna", "Tenor Sans", "Text Me One", "Texturina", "Thasadith", "The Girl Next Door", "Tienne", "Tillana", "Timmana", "Tinos", "Titan One", "Titillium Web", "Tomorrow", "Trade Winds", "Trirong", "Trispace", "Trocchi", "Trochut", "Trykker", "Tulpen One", "Turret Road", "Ubuntu", "Ubuntu Condensed", "Ubuntu Mono", "Ultra", "Uncial Antiqua", "Underdog", "Unica One", "UnifrakturCook", "UnifrakturMaguntia", "Unkempt", "Unlock", "Unna", "Vampiro One", "Varela", "Varela Round", "Varta", "Vast Shadow", "Vesper Libre", "Viaoda Libre", "Vibes", "Vibur", "Vidaloka", "Viga", "Voces", "Volkhov", "Vollkorn", "Vollkorn SC", "Voltaire", "VT323", "Waiting for the Sunrise", "Wallpoet", "Walter Turncoat", "Warnes", "Wellfleet", "Wendy One", "Wire One", "Work Sans", "Xanh Mono", "Yanone Kaffeesatz", "Yantramanav", "Yatra One", "Yellowtail", "Yeon Sung", "Yeseva One", "Yesteryear", "Yrsa", "Yusei Magic", "ZCOOL KuaiLe", "ZCOOL QingKe HuangYou", "ZCOOL XiaoWei", "Zeyada", "Zhi Mang Xing", "Zilla Slab", "Zilla Slab Highlight"];
                                                                var rureraform_localfonts = ["Arial", "Bookman", "Century Gothic", "Comic Sans MS", "Courier", "Garamond", "Georgia", "Helvetica", "Lucida Grande", "Palatino", "Tahoma", "Times", "Trebuchet MS", "Verdana"];
                                                                var rureraform_customfonts = [];
                                                                @php
                                                                echo
                                                                'var rureraform_toolbar_tools = '.json_encode($toolbar_tools);
                                                                @endphp;
                                                                @php
                                                                echo
                                                                'var rureraform_meta = '.json_encode($element_properties_meta);
                                                                @endphp;
                                                                var rureraform_validators = [];
                                                                var rureraform_filters = [];
                                                                var rureraform_confirmations = [];
                                                                var rureraform_notifications = [];
                                                                var rureraform_integrations = [];
                                                                var rureraform_payment_gateway = [];
                                                                var rureraform_math_expressions_meta = [];
                                                                var rureraform_logic_rules = [];
                                                                var rureraform_predefined_options = [];
                                                                @php
                                                                echo
                                                                'var rureraform_form_options = '.$tabs_options;
                                                                @endphp;
                                                                var rureraform_form_pages_raw = [{
                                                                    "general": "general",
                                                                    "name": "Page",
                                                                    "id": 1,
                                                                    "type": "page"
                                                                }];
                                                                //var rureraform_form_elements_raw = []; //Default Value for Questions
                                                                @php
																$layout_elements = isset( $layout_elements )? $layout_elements : array();
                                                                echo
                                                                'var rureraform_form_elements_raw = '.json_encode($layout_elements);
                                                                @endphp;
                                                                //var rureraform_form_elements_raw = ["{\"type\":\"image_quiz\",\"resize\":\"both\",\"height\":\"auto\",\"_parent\":\"1\",\"_parent-col\":\"0\",\"_seq\":0,\"id\":2,\"basic\":\"basic\",\"content\":\"    test     \",\"elements_data\":\"W3siMjM3OCI6eyJmaWVsZF90eXBlIjoiaW1hZ2UiLCJpbWFnZSI6Ii9zdG9yZS8xL2Rhc2hib2FyZC5wbmcifSwiNDAwNjEiOnsiZmllbGRfdHlwZSI6ImltYWdlIiwiaW1hZ2UiOiIvc3RvcmUvMS9kYXNoYm9hcmQucG5nIn19XQ==\"}"];
                                                                //var rureraform_form_elements_raw = ["{\"basic\":\"basic\",\"content\":\&lt;span class=&quot;block-holder&quot;&gt;&lt;img data-field_type=&quot;image&quot; data-id=&quot;2378&quot; id=&quot;field-2378&quot; class=&quot;editor-field&quot; src=&quot;\/store\/1\/dashboard.png&quot; heigh=&quot;50&quot; width=&quot;50&quot; data-image=&quot;\/store\/1\/dashboard.png&quot;&gt;&lt;\/span&gt;&amp;nbsp; &amp;nbsp; test&amp;nbsp; &amp;nbsp;&amp;nbsp;&lt;span class=&quot;block-holder&quot;&gt;&lt;img data-field_type=&quot;image&quot; data-id=&quot;40061&quot; id=&quot;field-40061&quot; class=&quot;editor-field&quot; src=&quot;\/store\/1\/default_images\/admin_dashboard.jpg&quot; heigh=&quot;50&quot; width=&quot;50&quot; data-image=&quot;\/store\/1\/default_images\/admin_dashboard.jpg&quot;&gt;&lt;\/span&gt;&amp;nbsp;&lt;br&gt;",\"elements_data\":{\"2378\":{\"data-field_type\":\"image\",\"data-id\":\"2378\",\"id\":\"field-2378\",\"class\":\"editor-field\",\"src\":\"\/store\/1\/dashboard.png\",\"heigh\":\"50\",\"width\":\"50\",\"data-image\":\"\/store\/1\/dashboard.png\"},\"40061\":{\"data-field_type\":\"image\",\"data-id\":\"40061\",\"id\":\"field-40061\",\"class\":\"editor-field\",\"src\":\"\/store\/1\/default_images\/admin_dashboard.jpg\",\"heigh\":\"50\",\"width\":\"50\",\"data-image\":\"\/store\/1\/default_images\/admin_dashboard.jpg\"}},\"type\":\"image_quiz\",\"resize\":\"both\",\"height\":\"auto\",\"_parent\":\"1\",\"_parent-col\":\"0\",\"_seq\":0,\"id\":2}"];
                                                                var rureraform_integration_providers = [];
                                                                var rureraform_payment_providers = [];
                                                                var rureraform_styles = [{
                                                                    "id": "native-35",
                                                                    "name": "Beige Beige",
                                                                    "type": 1
                                                                }, {
                                                                    "id": "native-31",
                                                                    "name": "Black and White",
                                                                    "type": 1
                                                                }, {
                                                                    "id": "native-30",
                                                                    "name": "Blue Lagoon",
                                                                    "type": 1
                                                                }, {
                                                                    "id": "native-45",
                                                                    "name": "Chamomile Tea",
                                                                    "type": 1
                                                                }, {
                                                                    "id": "native-32",
                                                                    "name": "Classic Green",
                                                                    "type": 1
                                                                }, {
                                                                    "id": "native-34",
                                                                    "name": "Dark Night",
                                                                    "type": 1
                                                                }, {
                                                                    "id": "native-29",
                                                                    "name": "Deep Space",
                                                                    "type": 1
                                                                }, {
                                                                    "id": "native-27",
                                                                    "name": "Default Style",
                                                                    "type": 1
                                                                }, {
                                                                    "id": "native-42",
                                                                    "name": "Greenery",
                                                                    "type": 1
                                                                }, {
                                                                    "id": "native-43",
                                                                    "name": "Honey Bee",
                                                                    "type": 1
                                                                }, {
                                                                    "id": "native-44",
                                                                    "name": "Honeysuckle",
                                                                    "type": 1
                                                                }, {
                                                                    "id": "native-47",
                                                                    "name": "Lava Rocks",
                                                                    "type": 1
                                                                }, {
                                                                    "id": "native-33",
                                                                    "name": "Light Blue",
                                                                    "type": 1
                                                                }, {
                                                                    "id": "native-40",
                                                                    "name": "Living Coral",
                                                                    "type": 1
                                                                }, {
                                                                    "id": "native-36",
                                                                    "name": "Mariana Trench",
                                                                    "type": 1
                                                                }, {
                                                                    "id": "native-37",
                                                                    "name": "Peach Button",
                                                                    "type": 1
                                                                }, {
                                                                    "id": "native-46",
                                                                    "name": "Something Blue",
                                                                    "type": 1
                                                                }, {
                                                                    "id": "native-41",
                                                                    "name": "Ultra Violet",
                                                                    "type": 1
                                                                }];
                                                                jQuery(document).ready(function () {
                                                                    rureraform_form_ready();
                                                                });
                                                                console.log(rureraform_form_elements_raw);
                                                            </script>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-5 col-md-5">
                                        <div class="lms-element-properties">
										
											<div class="topic-parts-block">
												<h3> Topics Parts </h3>
												<a href="javascript:;" class="add-part-modal">Add New Part</a>
												<div class="topic-parts-options"></div>
											</div>
										
	
										
                                            <div class="rureraform-admin-popup" id="rureraform-element-properties">
                                                <div class="rureraform-admin-popup-inner">
                                                    <div class="rureraform-admin-popup-title">
                                                        <a href="#" title="Close"
                                                           onclick="return rureraform_properties_close();"><i
                                                                    class="fas fa-times"></i></a>
                                                        <h3><i class="fas fa-cog element-properties-label"></i> Element Properties</h3>
                                                    </div>
                                                    <div class="rureraform-admin-popup-content">
                                                        <div class="rureraform-admin-popup-content-form">
                                                        </div>
                                                    </div>
                                                    <div class="rureraform-admin-popup-buttons">
                                                        <a class="rureraform-admin-button duplicate-element"
                                                           href="#"><label>Duplicate</label></a>
                                                        <a class="rureraform-admin-button remove-element"
                                                                                                                   href="#"><label>Remove</label></a>
                                                        <a class="rureraform-admin-button generate-question-code rurera-hide"
                                                           href="#"><label>Apply Changes</label></a>
                                                    </div>
                                                    <div class="rureraform-admin-popup-loading"><i
                                                                class="fas fa-spinner fa-spin"></i></div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="tab-pane mt-3 fade active show" id="question_properties" role="tabpanel"
                                                             aria-labelledby="question_properties-tab">


                                    <div class="col-12 col-md-12">
                                        <div class="row">


                                            <div class="col-12 col-md-12">
                                                <div class="row">
												


                                                    <div class="col-12">
													
												<div class="templates-buttons mb-20">
													<button class="btn btn-primary save-template"><i class="fas fa-save"></i> Save Template</button>
													<button class="btn btn-primary activate-template"><i class="fas fa-calendar-week"></i> Activate Template</button>
												</div>
														
                                                        <div class="search-fields-block"
                                                             style="background: #efefef;padding: 10px;"><div class="row">
															 
															 <div class="col-lg-6 col-md-6 col-12">
																	<div class="form-group">
																		<label class="input-label">Question Reference</label>
																		<input type="text" value="{{ isset( $question_title )? $question_title : old('title') }}"
																			   name="question_title"
																			   class="form-control @error('title')  is-invalid @enderror"
																			   placeholder=""/>
																		@error('title')
																		<div class="invalid-feedback">
																			{{ $message }}
																		</div>
																		@enderror
																	</div>
																</div>
																@php $categories_ids = isset( $questionObj->category_id )? json_decode($questionObj->category_id) : array();
                                                                $categories_ids = is_array( $categories_ids )? $categories_ids : array($categories_ids);
                                                                @endphp
															 
                                                            <div class="col-lg-6 col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label class="input-label">Year / Grade *</label>
                                                                    <select name="category_id[]"
                                                                data-course_id="{{isset( $questionObj->course_id )? $questionObj->course_id : 0}}"
                                                                data-plugin-selectTwo
                                                                class="form-control populate ajax-category-courses select2" multiple>
                                                                        <option value="">All</option>
																		@foreach($categories as $category)
																		@if(!empty($category->subCategories) and
																		count($category->subCategories))
																		<optgroup label="{{  $category->title }}">
																			@foreach($category->subCategories as $subCategory)
																			<option value="{{ $subCategory->id }}"
																					@if(in_array($subCategory->id, $categories_ids)) selected="selected" @endif>{{
																				$subCategory->title
																				}}
																			</option>
																			@endforeach
																		</optgroup>
																		@else
																		<option value="{{ $category->id }}" @if(request()->
																			get('category_id') ==
																			$category->id)
																			selected="selected" @endif>{{ $category->title }}
																		</option>
                                                                        @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label class="input-label">Subject *</label>
                                                                    <select data-chapter_id="{{isset( $questionObj->chapter_id )? $questionObj->chapter_id : 0}}"
																			name="course_id"
																			data-plugin-selectTwo
																			class="form-control populate ajax-courses-dropdown">
																		<option value="">Please select year</option>
																	</select>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label class="input-label">Topic</label>
                                                                    <select data-sub_chapter_id="{{isset( $questionObj->sub_chapter_id ) ? $questionObj->sub_chapter_id : 0}}" id="chapter_id"
																			class="form-control populate ajax-chapter-dropdown"
																			name="chapter_id">
																		<option value="">Please select year, subject</option>
																	</select>

                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label class="input-label">Sub Topic</label>
                                                                    <select data-topics_parts="{{isset( $questionObj->topics_parts ) ? $questionObj->topics_parts : ''}}" id="chapter_id"
																		class="form-control populate ajax-subchapter-dropdown"
																		name="sub_chapter_id">
																	<option value="">Please select year, subject, Topic</option>
																</select>

                                                                </div>
                                                            </div>
															@php $question_type = isset( $question_type )? $question_type : '';
															$question_difficulty_level = isset( $question_difficulty_level )? $question_difficulty_level : '';
															$reference_type = isset( $reference_type )? $reference_type : '';
															
															@endphp
															<div class="col-lg-6 col-md-6 col-12 rurera-hide">
																<div class="form-group">
																	<label class="input-label">Question Type</label>
																	<select name="question_type" class="custom-select ">
																		<option value="" {{ ($question_type=='') ? 'selected' : '' }}>Select Type</option>
																		<option value="dropdown" {{ ($question_type=='dropdown') ? 'selected' : '' }}>Dropdown</option>
																		<option value="true_false" {{ ($question_type=='true_false') ? 'selected' : '' }}>True False</option>
																		<option value="matching" {{ ($question_type=='matching') ? 'selected' : '' }}>Matching</option>
																		<option value="sorting" {{ ($question_type=='sorting') ? 'selected' : '' }}>Sorting</option>
																		<option value="single_select" {{ ($question_type=='single_select') ? 'selected' : '' }}>Single Select</option>
																		<option value="text_field" {{ ($question_type=='text_field') ? 'selected' : '' }}>Text Field</option>
																		<option value="multi_select" {{ ($question_type=='multi_select') ? 'selected' : '' }}>Multi Select</option>
																		<option value="short_answer" {{ ($question_type=='short_answer') ? 'selected' : '' }}>Short Answer</option>
																	</select>
																</div>
															</div>

															<div class="col-lg-6 col-md-6 col-12">
																<div class="form-group">
																	<label class="input-label">Difficulty Level</label>
																	<select name="difficulty_level" class="custom-select ">
																		<option value="Emerging" {{ ($question_difficulty_level==
																		'Emerging') ? 'selected' : '' }}>Emerging</option>
																		<option value="Expected" {{ ($question_difficulty_level==
																		'Expected') ? 'selected' : '' }}>Expected</option>
																		<option value="Exceeding" {{ ($question_difficulty_level==
																		'Exceeding') ? 'selected' : '' }}>Exceeding</option>
																	</select>
																</div>
															</div>

                                                            
                                                        </div>
                                                    </div>
                                                    </div>

													
													<div class="col-lg-12 col-md-12 col-12">
                                                        <div class="form-group">
                                                            <label class="input-label">Reference Type</label>
                                                            <select name="reference_type" class="custom-select ">
																<option value="Course" {{ ($reference_type==
																'Course') ? 'selected' : '' }}>Course</option>
																<option value="Mock Exams" {{ ($reference_type==
																'Mock Exams') ? 'selected' : '' }}>Mock Exams</option>
																<option value="Both" {{ ($reference_type==
																'Both') ? 'selected' : '' }}>Both</option>
															</select>
                                                        </div>
                                                    </div>
													
                                                    <div class="col-lg-6 col-md-6 col-12 rurera-hide">
                                                        <div class="form-group">
                                                            <label class="input-label">Example Question</label>
                                                            <select name="example_question" id="example_question" data-search-option="questions_ids"
                                                                  class="form-control search-question-select2" data-placeholder="Search Question"></select>
                                                        </div>
                                                    </div>

                                                    

                                                    <div class="col-lg-6 col-md-6 col-12 rurera-hide">
                                                        <div class="form-group">
                                                            <label class="input-label">Correct Answer Score</label>
                                                            <input type="text" value="1"
                                                                   name="question_score"
                                                                   class="form-control @error('title')  is-invalid @enderror"
                                                                   placeholder=""/>
                                                            @error('title')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-12 rurera-hide">
                                                        <div class="form-group">
                                                            <label class="input-label">Average Time</label>
                                                            <input type="text" value="{{ isset( $question_average_time)? $question_score : old('question_average_time') }}"
                                                                   name="question_average_time"
                                                                   class="form-control @error('title')  is-invalid @enderror"
                                                                   placeholder=""/>
                                                            @error('title')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    
													
													<div class="col-12">
														<div class="form-group">
															<label class="input-label">Search Keywords / Tags (Enter Search terms which will be use when looking for your questions)</label>
															@php
															$search_tags = isset( $questionObj->search_tags )? $questionObj->search_tags : '';
															$search_tags = explode(' | ', $search_tags);
															$search_tags = implode(',', $search_tags);
															@endphp
															<input type="text" data-role="tagsinput" value="{{ $search_tags }}"
																   name="search_tags"
																   class="form-control @error('search_tags')  is-invalid @enderror"
																   placeholder="List of comma-Separated Search keywords (i.e. Subject-title, topic)"/>
															@error('search_tags')
															<div class="invalid-feedback">
																{{ $message }}
															</div>
															@enderror
															<span>5 tags maximum, user letters  and numbers only</span>
														</div>
													</div>
													
													
													
													<div class="col-lg-6 col-md-6 col-12">
														<div class="form-group custom-switches-stacked">
															<label class="custom-switch pl-0">
																<input type="hidden" name="review_required_field" value="disable">
																<input type="checkbox"
																		   name="review_required"
																		   id="review_required" value="1" {{ (isset( $questionObj->review_required ) && $questionObj->review_required
																	== '1') ?
																	'checked="checked"' : ''
																	}} class="custom-switch-input"/>
																	<span class="custom-switch-indicator"></span>
																	<label class="custom-switch-description mb-0 cursor-pointer"
																		   for="review_required">Teacher Review Required</label>
															</label>
														</div>
													</div>
													
													
													<div class="col-lg-6 col-md-6 col-12">
														<div class="form-group custom-switches-stacked">
															<label class="custom-switch pl-0">
																<input type="hidden" name="developer_review_required_field" value="disable">
																<input type="checkbox"
																		   name="developer_review_required"
																		   id="developer_review_required" value="1" {{ (isset( $questionObj->developer_review_required ) && $questionObj->developer_review_required
																	== '1') ?
																	'checked="checked"' : ''
																	}} class="custom-switch-input"/>
																	<span class="custom-switch-indicator"></span>
																	<label class="custom-switch-description mb-0 cursor-pointer"
																		   for="developer_review_required">Developer Review Required</label>
															</label>
														</div>
													</div>
													
													
                                                    <div class="col-lg-6 col-md-6 col-12">
                                                        <div class="form-group custom-switches-stacked">
                                                            <label class="custom-switch pl-0">
                                                                <input type="hidden" name="hide_question_field" value="disable">
                                                                <input type="checkbox"
                                                                           name="hide_question"
                                                                           id="hide_question" value="1" {{ (isset( $questionObj->hide_question ) && $questionObj->hide_question
                                                                    == '1') ?
                                                                    'checked="checked"' : ''
                                                                    }} class="custom-switch-input"/>
                                                                    <span class="custom-switch-indicator"></span>
                                                                    <label class="custom-switch-description mb-0 cursor-pointer"
                                                                           for="hide_question">Hide Question</label>
                                                            </label>
                                                        </div>
                                                    </div>



                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <div class="tab-pane mt-3 fade" id="glossary_solution" role="tabpanel"
                                                         aria-labelledby="glossary_solution-tab">

								@php $glossary  = isset( $glossary )? $glossary : array(); $glossary_ids = isset( $glossary_ids )? $glossary_ids : array(); @endphp

                                <div class="col-12 col-md-12">
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                            <div class="form-group">
                                                <label class="input-label">Glossary</label>
                                                <select name="glossary_ids[]" id="glossary_ids"
                                                        class="glossary-items form-control"
                                                        multiple>
                                                    @if(!empty($glossary))
                                                    @foreach($glossary as $glossaryData)
                                                    @php $selected = '' @endphp
                                                    @if(in_array($glossaryData->id, $glossary_ids))
                                                    @php $selected = 'selected' @endphp
                                                    @endif
                                                    <option value="{{ $glossaryData->id }}" {{$selected}}>{{
                                                        $glossaryData->title }}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <a href="javascript:;" class="add-glossary-modal">Add New Glossary</a>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 rurera-hide">
                                            <div class="form-group">
                                                <label class="input-label">Question Example</label>
                                                <textarea class="note-codable summernote" id="question_example"
                                                          name="question_example"
                                                          aria-multiline="true">{{isset( $question_example )? $question_example : ''}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12">
                                            <div class="form-group">
                                                <label class="input-label">Solution</label>
                                                <textarea class="note-codable summernote" id="question_solve"
                                                          name="question_solve"
                                                          aria-multiline="true">{{isset( $question_solve )? $question_solve : ''}}</textarea>
                                            </div>
                                        </div>
                                </div>
                                </div>
                            </div>
                            <div class="tab-pane mt-3 fade" id="review_required_tab" role="tabpanel"
                                                     aria-labelledby="review_required_tab-tab">


                            <div class="col-12 col-md-12">
                                <div class="row">

                                    
									@php $question_status = isset( $questionObj->question_status )? $questionObj->question_status : ''; @endphp
									@if(auth()->user()->isReviewer())
									@if($question_status == 'Submit for review' ||
									$question_status ==
									'On hold')
									<div class="col-12">
										<button type="button" data-question_id="{{$questionObj->id}}"
												class="question-action-btn btn btn-warning">Action
										</button>
									</div>
									@endif
									@endif


                                    @if(auth()->user()->isTeacher() || auth()->user()->isAuthor())
                                    <div class="col-12 col-md-12">
                                        <div class="form-group">
                                            <label class="input-label">Comments for Reviewer</label>
                                            <textarea class="note-codable summernote" id="comments_for_reviewer"
                                                      name="comments_for_reviewer" aria-multiline="true"></textarea>
                                        </div>
                                    </div>
                                    @endif

                                </div>
                            </div>
                        </div>

                            <div class="tab-pane mt-3 fade" id="question_preview" role="tabpanel"
                                                             aria-labelledby="question_preview-tab">




                                    <div class="question-area">
                                        <div class="question-step question-step-0" data-elapsed="0"
                                             data-qattempt="0"
                                             data-start_time="0" data-qresult="tstttt111"
                                             data-quiz_result_id="0">
                                            <div class="question-layout-block" style="width: 100%;">

                                                <form class="question-fields" action="javascript:;" data-question_id="0">
                                                    <div class="left-content has-bg">

														<div class="quiz-status-bar">
															<div class="quiz-questions-bar-holder">
																
																<div class="quiz-questions-bar">
																	<span class="value-lable" data-title="Target" style="left:90%"><span>90%</span></span>
																	<span class="bar-fill" title="0%" style="width: 0%;"></span>
																</div>
																<span class="coin-numbers">
																	<img src="/assets/default/img/quests-coin.png" alt="">
																	<span class="total-earned-coins">0</span>
																</span>
															</div>
															<div class="quiz-corrects-incorrects">
																<span class="quiz-corrects">0</span>
																<span class="quiz-incorrects">0</span>
															</div>
														</div>
													
                                                        <span class="question-number-holder" style="z-index: 999999999;"> <span class="question-number">1</span>
                                                        </span>


                                                        @php $classes = isset( $class )? $class : ''; @endphp
                                                        <div id="rureraform-form-1"
                                                             class="disable-div"
                                                             _data-parent="1"
                                                             _data-parent-col="0" style="display: block;">
                                                            <div class="question-layout">
                                                                <div class="question-layout-data"></div>
                                                            </div>

                                                        </div>
                                                        <div class="show-notifications"></div>

                                                        <div class="prev-next-controls text-center questions-nav-controls">

                                                            @if( !isset( $disable_finish ) || $disable_finish == 'false')
                                                            <a href="javascript:;" data-toggle="modal" class=" review-btn {{isset($rev_btn_class)? $rev_btn_class : ''}}" data-target="#review_submit">
                                                                Finish
                                                                <svg style="width: 22px;height: 22px;" xmlns="http://www.w3.org/2000/svg" version="1.0"
                                                                     width="512.000000pt" height="512.000000pt"
                                                                     viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                                                                       stroke="none">
                                                                        <path
                                                                                d="M1405 5080 c-350 -40 -655 -161 -975 -388 -18 -13 -21 -9 -48 47 -24 50 -28 70 -24 114 12 153 -150 248 -279 162 -42 -27 -79 -96 -79 -146 0 -47 38 -120 76 -144 18 -11 39 -24 47 -30 9 -5 498 -1013 1088 -2240 589 -1227 1088 -2264 1109 -2305 45 -89 80 -115 142 -107 65 9 115 71 105 132 -3 18 -228 496 -501 1063 -273 566 -496 1034 -496 1038 1 5 29 30 63 55 204 153 442 257 707 311 164 33 453 33 618 0 179 -36 311 -84 537 -197 128 -64 257 -120 330 -144 358 -117 765 -109 1118 19 90 33 130 65 158 125 22 48 24 89 5 141 -34 96 -999 2081 -1024 2107 -66 70 -129 76 -282 27 -181 -57 -256 -70 -415 -77 -170 -6 -278 5 -430 44 -133 34 -213 67 -413 167 -250 125 -368 166 -586 207 -127 23 -421 33 -551 19z m665 -297 c123 -34 232 -79 405 -167 77 -40 163 -81 190 -92 l50 -20 99 -210 c54 -115 101 -215 104 -222 2 -8 -35 6 -84 31 -179 90 -382 152 -576 178 l-93 12 -117 246 c-64 135 -120 255 -124 265 -8 22 -10 22 146 -21z m-814 -297 c74 -154 134 -284 134 -290 0 -6 -28 -22 -62 -35 -131 -49 -324 -161 -447 -260 -35 -29 -68 -48 -72 -44 -9 10 -290 595 -287 598 2 1 30 22 63 47 82 62 206 138 290 178 90 43 216 90 234 87 7 -1 74 -128 147 -281z m2804 -279 c88 -183 135 -290 127 -292 -153 -51 -500 -94 -523 -64 -15 20 -254 525 -254 536 0 6 37 13 82 17 94 8 216 33 333 70 44 13 84 24 88 23 4 -1 71 -132 147 -290z m-1739 -274 l166 -348 -176 -7 c-185 -7 -321 -28 -471 -72 -47 -14 -88 -22 -91 -18 -19 22 -328 687 -322 693 13 11 181 55 278 73 114 20 139 22 310 24 l141 2 165 -347z m729 47 c121 -62 328 -119 506 -140 l101 -12 91 -191 c50 -106 125 -263 167 -351 l75 -158 -67 7 c-186 18 -390 76 -545 154 l-92 46 -109 230 c-60 127 -133 280 -162 342 -59 124 -60 121 35 73z m-321 -451 c131 -27 312 -89 433 -149 57 -28 108 -57 114 -63 14 -15 306 -628 301 -633 -2 -2 -41 15 -88 38 -168 82 -416 155 -593 175 l-69 8 -153 323 c-85 177 -154 325 -154 328 0 9 99 -4 209 -27z m-835 -381 c81 -172 147 -317 146 -323 -2 -5 -40 -24 -84 -41 -164 -63 -298 -135 -431 -231 -32 -24 -62 -43 -65 -43 -6 0 -75 140 -236 477 l-63 132 62 49 c139 108 281 193 437 259 41 18 77 32 80 33 3 0 72 -141 154 -312z m2811 -281 l154 -318 -27 -10 c-106 -41 -319 -79 -438 -79 l-71 0 -152 321 c-84 176 -151 323 -148 325 2 3 66 9 141 14 124 9 296 39 350 60 12 5 25 8 30 6 4 -1 77 -145 161 -319z"></path>
                                                                    </g>
                                                                </svg>
                                                            </a>
                                                            @endif

                                                            @php $prev_class = (isset( $prev_question ) && $prev_question > 0)? '' : ''; @endphp
                                                            @if( !isset( $disable_prev ) || $disable_prev == 'false')
                                                            <a href="javascript:;" id="prev-btn" class="rurera-hide {{$prev_class}} prev-btn {{isset( $prev_btn_class)? $prev_btn_class : ''}}"
                                                               data-question_id="0">
                                                                <svg style="width: 22px;height: 22px;" xmlns="http://www.w3.org/2000/svg" version="1.0"
                                                                     width="512.000000pt" height="512.000000pt"
                                                                     viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                                                                       stroke="none">
                                                                        <path
                                                                                d="M3620 5103 c-39 -13 -198 -168 -1238 -1207 -1095 -1093 -1194 -1195 -1212 -1244 -25 -67 -25 -117 0 -184 18 -49 117 -151 1212 -1244 1141 -1140 1195 -1193 1247 -1209 214 -69 408 147 315 352 -11 25 -377 398 -1093 1115 l-1076 1078 1076 1077 c701 703 1082 1091 1093 1115 61 135 -4 297 -140 348 -64 23 -121 24 -184 3z"></path>
                                                                    </g>
                                                                </svg>
                                                            </a>
                                                            @endif
                                                            @php $next_class = (isset( $next_question ) && $next_question > 0)? '' : ''; @endphp
                                                            @if( !isset( $disable_next ) || $disable_next == 'false')
                                                            <a href="javascript:;" id="next-btn" class="rurera-hide {{$next_class}} next-btn {{isset( $next_btn_class)? $next_btn_class : ''}}"
                                                               data-question_id="0">
                                                                Next
                                                                <svg style="width: 22px;height: 22px;" xmlns="http://www.w3.org/2000/svg" version="1.0"
                                                                     width="512.000000pt" height="512.000000pt"
                                                                     viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                                                                       stroke="none">
                                                                        <path
                                                                                d="M1340 5111 c-118 -36 -200 -156 -187 -272 3 -27 14 -66 23 -86 11 -25 377 -398 1093 -1116 l1076 -1077 -1076 -1078 c-716 -717 -1082 -1090 -1093 -1115 -61 -135 4 -296 140 -347 66 -24 114 -25 180 -4 45 15 146 113 1242 1208 1095 1093 1194 1195 1212 1244 11 29 20 70 20 92 0 22 -9 63 -20 92 -18 49 -117 151 -1212 1244 -1096 1095 -1197 1193 -1242 1208 -52 17 -114 20 -156 7z"></path>
                                                                    </g>
                                                                </svg>
                                                            </a>
                                                            @endif
                                                            @if( !isset( $disable_submit ) || $disable_submit == 'false')
                                                            <a href="javascript:;" id="question-submit-btn" class="question-submit-btn {{isset( $submit_class)? $submit_class : ''}}">
                                                                mark answer
                                                                <svg style="width: 22px;height: 22px;" xmlns="http://www.w3.org/2000/svg" version="1.0"
                                                                     width="512.000000pt" height="512.000000pt"
                                                                     viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                                                                       stroke="none">
                                                                        <path
                                                                                d="M1405 5080 c-350 -40 -655 -161 -975 -388 -18 -13 -21 -9 -48 47 -24 50 -28 70 -24 114 12 153 -150 248 -279 162 -42 -27 -79 -96 -79 -146 0 -47 38 -120 76 -144 18 -11 39 -24 47 -30 9 -5 498 -1013 1088 -2240 589 -1227 1088 -2264 1109 -2305 45 -89 80 -115 142 -107 65 9 115 71 105 132 -3 18 -228 496 -501 1063 -273 566 -496 1034 -496 1038 1 5 29 30 63 55 204 153 442 257 707 311 164 33 453 33 618 0 179 -36 311 -84 537 -197 128 -64 257 -120 330 -144 358 -117 765 -109 1118 19 90 33 130 65 158 125 22 48 24 89 5 141 -34 96 -999 2081 -1024 2107 -66 70 -129 76 -282 27 -181 -57 -256 -70 -415 -77 -170 -6 -278 5 -430 44 -133 34 -213 67 -413 167 -250 125 -368 166 -586 207 -127 23 -421 33 -551 19z m665 -297 c123 -34 232 -79 405 -167 77 -40 163 -81 190 -92 l50 -20 99 -210 c54 -115 101 -215 104 -222 2 -8 -35 6 -84 31 -179 90 -382 152 -576 178 l-93 12 -117 246 c-64 135 -120 255 -124 265 -8 22 -10 22 146 -21z m-814 -297 c74 -154 134 -284 134 -290 0 -6 -28 -22 -62 -35 -131 -49 -324 -161 -447 -260 -35 -29 -68 -48 -72 -44 -9 10 -290 595 -287 598 2 1 30 22 63 47 82 62 206 138 290 178 90 43 216 90 234 87 7 -1 74 -128 147 -281z m2804 -279 c88 -183 135 -290 127 -292 -153 -51 -500 -94 -523 -64 -15 20 -254 525 -254 536 0 6 37 13 82 17 94 8 216 33 333 70 44 13 84 24 88 23 4 -1 71 -132 147 -290z m-1739 -274 l166 -348 -176 -7 c-185 -7 -321 -28 -471 -72 -47 -14 -88 -22 -91 -18 -19 22 -328 687 -322 693 13 11 181 55 278 73 114 20 139 22 310 24 l141 2 165 -347z m729 47 c121 -62 328 -119 506 -140 l101 -12 91 -191 c50 -106 125 -263 167 -351 l75 -158 -67 7 c-186 18 -390 76 -545 154 l-92 46 -109 230 c-60 127 -133 280 -162 342 -59 124 -60 121 35 73z m-321 -451 c131 -27 312 -89 433 -149 57 -28 108 -57 114 -63 14 -15 306 -628 301 -633 -2 -2 -41 15 -88 38 -168 82 -416 155 -593 175 l-69 8 -153 323 c-85 177 -154 325 -154 328 0 9 99 -4 209 -27z m-835 -381 c81 -172 147 -317 146 -323 -2 -5 -40 -24 -84 -41 -164 -63 -298 -135 -431 -231 -32 -24 -62 -43 -65 -43 -6 0 -75 140 -236 477 l-63 132 62 49 c139 108 281 193 437 259 41 18 77 32 80 33 3 0 72 -141 154 -312z m2811 -281 l154 -318 -27 -10 c-106 -41 -319 -79 -438 -79 l-71 0 -152 321 c-84 176 -151 323 -148 325 2 3 66 9 141 14 124 9 296 39 350 60 12 5 25 8 30 6 4 -1 77 -145 161 -319z"></path>
                                                                    </g>
                                                                </svg>
                                                            </a>


                                                            @endif
                                                        </div>
                                                    </div>


													@if( isset( $questionObj->id ))
															<input type="hidden" name="question_id" value="{{$questionObj->id}}">	
													@endif
                                                </form>

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


    <div class="row">
        <div class="col-12 col-md-12">


            @include('admin.questions_bank.question_editor_fields_controls')


            <div class="mt-5 mb-5 create-question-fields-block">
                <button type="button" data-status="Draft" class="quiz-stage-generate btn btn-warning">Draft</button>
                <button type="button" data-status="Submit for review" class="quiz-stage-generate btn btn-primary">
                    Submit for review
                </button>
                <button type="submit" class="submit-btn-quiz-create btn btn-primary hide">{{ !empty($quiz) ?
                    trans('admin/main.save_change') : trans('admin/main.create') }}
                </button>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
</section>

<div id="add-glosary-modal-box" class="question_glossary_modal modal fade question_status_action_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form name="question_status_action_form" id="question_status_action_form">
                    <div class="form-group">
                        <label>{{ trans('/admin/main.category') }}</label>
                        <select class="form-control @error('category_id') is-invalid @enderror year_subject_ajax_select"
                                name="ajax[category_id]">
                            <option {{ !empty($trend) ?
                            '' : 'selected' }} disabled>{{ trans('admin/main.choose_category') }}</option>

                            @foreach($categories as $category)
                            @if(!empty($category->subCategories) and count($category->subCategories))
                            <optgroup label="{{  $category->title }}">
                                @foreach($category->subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}">{{ $subCategory->title }}</option>
                                @endforeach
                            </optgroup>
                            @endif
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                            <label>Subjects</label>
                            <select data-return_type="option"
                                    data-default_id="0"
                                    class="subject_ajax_select year_subjects form-control select2 @error('subject_id') is-invalid @enderror"
                                    id="subject_id" name="ajax[subject_id]">
                                <option disabled selected>Subject</option>
                            </select>
                            @error('subject_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                    <div class="form-group">
                        <label>Glossary Title</label>
                        <input type="text" name="ajax[title]" class="form-control  @error('title') is-invalid @enderror"
                               placeholder="{{ trans('admin/main.choose_title') }}"/>
                        @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="input-label">Description</label>
                        <textarea class="note-codable summernote" id="description" name="ajax[description]"
                                  aria-multiline="true"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="text-right">
                    <a href="javascript:;" class="btn btn-primary question_glossary_submit_btn">Submit</a>
                </div>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="add-part-modal-box" class="question_part_modal modal fade question_status_action_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form name="question_status_action_form" id="question_status_action_form">
                    <div class="form-group">
						<label>Paragraph</label>
						<textarea class="form-control @error('paragraph') is-invalid @enderror" rows="10" name="paragraph" id="inputText" placeholder="Enter the paragraph here...">{{isset( $TopicParts->paragraph ) ? $TopicParts->paragraph : old('paragraph')}}</textarea>
					</div>
					<input type="hidden" name="question_id" value="{{$questionObj->id}}">
					
					<button id="splitTextBtn" type="button">Split Text into Parts</button>
					<button id="addMoreBtn" type="button">Add More</button>

					
					<table id="outputTable">
						<thead>
							<tr>
								<th>Unique ID</th>
								<th>Text Part</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="sortableTableBody">
							
						</tbody>
					</table>
					
                </form>
            </div>
            <div class="modal-footer">
                <div class="text-right">
                    <a href="javascript:;" class="btn btn-primary question_topic_part_submit_btn">Submit</a>
                </div>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div id="template_display_modal" class="template_display_modal modal fade" role="dialog" data-backdrop="static">>
    <div class="modal-dialog">
        <div class="modal-content edit-quest-modal-div">
            <div class="modal-body">
			  <div class="modal-box">
				<h3 class="font-24 font-weight-normal mb-10">Activate Template</h3>
				@php $saved_templates = $user->saved_templates;
					$saved_templates = json_decode( $saved_templates );
					$saved_templates = isset( $saved_templates->question_form )? $saved_templates->question_form : array();
				@endphp
				<ul class="apply-template-field">
					@if( !empty( $saved_templates ) )
						@foreach( $saved_templates  as $template_name => $template_data)
							<li data-template_data="{{$template_data}}"> <span>{{$template_name}}</span> <a href="javascript:;" data-template_name="{{$template_name}}" class="remove-template"><i class="fas fa-times"></i></a></li>
						@endforeach
					@endif
					
				</ul>
				
				<div class="inactivity-controls mt-10">
					<a href="javascript:;" class="close" data-dismiss="modal" aria-label="Continue">Close</a>
				</div>
			  </div>
			</div>
        </div>
    </div>
</div>

<div id="template_save_modal" class="template_save_modal modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content edit-quest-modal-div">
            <div class="modal-body">
			  <div class="modal-box">
				<h3 class="font-24 font-weight-normal mb-10">Save the Template</h3>
				<p class="mb-15 font-16">
					<input type="text" name="template_name" class="template_name form-control">
				</p>
				<input type="hidden" name="form_data_encoded" class="form_data_encoded">
				
				<div class="inactivity-controls">
					<a href="javascript:;" class="continue-btn save-template-btn">Save Template</a>
					<a href="javascript:;" class="close" data-dismiss="modal" aria-label="Continue">Close</a>
				</div>
			  </div>
			</div>
        </div>
    </div>
</div>


<div id="question_status_action_modal" class="modal fade question_status_action_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Question Actions</h3>
            </div>
            <div class="modal-body">
                <form name="question_status_action_form" id="question_status_action_form">
                    <div class="row">

                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <select name="question_status" class="question_status_update custom-select">
                                    <option value="">Action</option>
                                    <option value="Accepted" selected="selected">Accepted</option>
                                    <option value="On hold">On hold</option>
                                    <option value="Improvement required">Improvement required</option>
                                    <option value="Hard reject">Hard reject</option>
                                </select>
                            </div>
                        </div>

                        <div class="question-status-fields" data-status_label="Accepted">
                            <div class="col-12 col-md-12">
                                <div class="form-group custom-switches-stacked mt-2">
                                    <label class="custom-switch pl-0">
                                        <input type="checkbox" name="image_question" id="image_question" value="1"
                                               class="custom-switch-input"/>
                                        <span class="custom-switch-indicator"></span>
                                        <label class="custom-switch-description mb-0 cursor-pointer"
                                               for="image_question">Image Question</label>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 col-md-12">
                                <div class="form-group custom-switches-stacked mt-2">
                                    <label class="custom-switch pl-0">
                                        <input type="checkbox" name="word_problem" id="word_problem" value="1"
                                               class="custom-switch-input"/>
                                        <span class="custom-switch-indicator"></span>
                                        <label class="custom-switch-description mb-0 cursor-pointer" for="word_problem">Word
                                            Problem</label>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 col-md-12">
                                <div class="form-group custom-switches-stacked mt-2">
                                    <label class="custom-switch pl-0">
                                        <input type="checkbox" name="new_glossary" id="new_glossary" value="1"
                                               class="custom-switch-input"/>
                                        <span class="custom-switch-indicator"></span>
                                        <label class="custom-switch-description mb-0 cursor-pointer" for="new_glossary">New
                                            Glossary</label>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 col-md-12 glossary_illustration_field hide">
                                <div class="form-group custom-switches-stacked mt-2">
                                    <label class="custom-switch pl-0">
                                        <input type="checkbox" name="glossary_with_illustration"
                                               id="glossary_with_illustration" value="1" class="custom-switch-input"/>
                                        <span class="custom-switch-indicator"></span>
                                        <label class="custom-switch-description mb-0 cursor-pointer"
                                               for="glossary_with_illustration">Glossary with Illustration</label>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 col-md-12">

                                <label class="input-label">Solution</label>
                                <input type="radio" class="btn-check" name="solution" id="Acceptable" value="Acceptable"
                                       autocomplete="off" checked="checked">
                                <label class="btn btn-secondary" for="Acceptable">Acceptable</label>

                                <input type="radio" class="btn-check" name="solution" id="Appropriate"
                                       value="Appropriate" autocomplete="off">
                                <label class="btn btn-secondary" for="Appropriate">Appropriate</label>

                                <input type="radio" class="btn-check" name="solution" id="Aspirational"
                                       value="Aspirational" autocomplete="off">
                                <label class="btn btn-secondary" for="Aspirational">Aspirational</label>
                            </div>

                            <div class="col-12 col-md-12">
                                <label class="input-label">Difficulty Level</label>
                                <input type="radio" class="btn-check" name="difficulty_level" id="Standard"
                                       value="Standard" autocomplete="off" checked="checked">
                                <label class="btn btn-secondary" for="Standard">Standard</label>

                                <input type="radio" class="btn-check" name="difficulty_level" id="Medium" value="Medium"
                                       autocomplete="off">
                                <label class="btn btn-secondary" for="Medium">Medium</label>

                                <input type="radio" class="btn-check" name="difficulty_level" id="Expert" value="Expert"
                                       autocomplete="off">
                                <label class="btn btn-secondary" for="Expert">Expert</label>
                            </div>


                            <div class="col-12 col-md-12">
                                <div class="form-group custom-switches-stacked mt-2">
                                    <label class="custom-switch pl-0">
                                        <input type="checkbox" name="publish_question" id="publish_question" value="1"
                                               class="custom-switch-input"/>
                                        <span class="custom-switch-indicator"></span>
                                        <label class="custom-switch-description mb-0 cursor-pointer"
                                               for="publish_question">Publish</label>
                                    </label>
                                </div>
                            </div>
                        </div>


                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label class="input-label">Details</label>
                                <textarea class="note-codable summernote" id="status_details" name="status_details"
                                          aria-multiline="true"></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="question_id" value="{{isset( $questionObj->id ) ? $questionObj->id : 0}}">
                </form>
            </div>
            <div class="modal-footer">
                <div class="text-right">
                    <a href="javascript:;" class="btn btn-primary question_status_submit_btn">Submit</a>
                </div>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/feather-icons/dist/feather.min.js"></script>
<script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>
<script src="/assets/vendors/summernote/summernote-table-headers.js"></script>
<script src="/assets/default/vendors/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>

<script>
    // Function to generate a random alphanumeric ID (6 characters: mix of letters and numbers)
    function generateUniqueID() {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let result = '';
        for (let i = 0; i < 6; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return result;
    }

    // Function to add a new row to the table
    function addNewRow(part = '') {
        const uniqueID = generateUniqueID();
        const tableBody = document.getElementById('sortableTableBody');
        const row = document.createElement('tr');
        
        row.innerHTML = `
            <td>${uniqueID}</td>
            <td><textarea name="topic_part[${uniqueID}]">${part}</textarea></td>
            <td><button class="remove-btn" onclick="removeRow(this)">Remove</button></td>
        `;
        tableBody.appendChild(row);
    }

    // Function to remove a row
    function removeRow(button) {
        const row = button.parentElement.parentElement;
        row.remove();
    }

    // Event listener to split the input text into parts
    document.getElementById('splitTextBtn').addEventListener('click', function() {
        const inputText = document.getElementById('inputText').value;
        
        // Split the text into sentences using basic sentence boundary detection
        const parts = inputText.split(/(?<=[.?!])\s+/);
        
        const outputTableBody = document.getElementById('sortableTableBody');
        outputTableBody.innerHTML = '';  // Clear previous output
        
        // Loop through each part and add it as a new row
        parts.forEach(part => {
            addNewRow(part);
        });
    });

    // Event listener to add more parts dynamically
    document.getElementById('addMoreBtn').addEventListener('click', function() {
        addNewRow(); // Add an empty new row
    });

    // Initialize sortable functionality on the table body
    new Sortable(document.getElementById('sortableTableBody'), {
        animation: 150,
        handle: 'td', // Make the table row (td) the handle for sorting
        ghostClass: 'sortable-ghost'
    });
</script>
<script type="text/javascript">

    $(document).ready(function () {

        $('.glossary-items').select2();
        $(".question-no-field").draggable({
            containment: ".rureraform-builder",
        });

    });

    var saveSuccessLang = '{{ trans("webinars.success_store") }}';
</script>


<script src="/assets/default/js/admin/quiz.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        handleMultiSelect2('search-question-select2', '/admin/questions_bank/search', ['class', 'course', 'subject', 'title']);
    });
	$(document).ready(function () {
        $('.ajax-category-courses').change();
        $('.glossary-items').select2();
    });
</script>

<script type="text/javascript">
    $("body").on("click", ".add-glossary-modal", function (t) {
        $("#add-glosary-modal-box").modal({backdrop: "static"});
    });
	
	$("body").on("click", ".add-part-modal", function (t) {
		$("#inputText").val('');
		$("#sortableTableBody").html('');
        $("#add-part-modal-box").modal({backdrop: "static"});
    });
	
	$("body").on("click", ".question-action-btn", function (t) {
        $("#question_status_action_modal").modal({backdrop: "static"});
    });
		
	
	
	var is_template_active = false;
	var course_id_template = '';
	var chapter_id_template = '';
	var sub_chapter_id_template = '';

    $(document).on('change', '.ajax-category-courses', function () {
        var category_id = $(this).val();
        var course_id = $(this).attr('data-course_id');
        $.ajax({
            type: "GET",
            url: '/admin/webinars/courses_by_categories',
            data: {'category_id': category_id, 'course_id': course_id},
            success: function (return_data) {
                $(".ajax-courses-dropdown").html(return_data);
                $(".ajax-chapter-dropdown").html('<option value="">Please select year, subject</option>');
                $('.ajax-courses-dropdown').change();
            }
        });
    });

    $(document).on('change', '.ajax-courses-dropdown', function () {
        var course_id = $(this).val();
        var chapter_id = $(this).attr('data-chapter_id');

        $.ajax({
            type: "GET",
            url: '/admin/webinars/chapters_by_course',
            data: {'course_id': course_id, 'chapter_id': chapter_id},
            success: function (return_data) {
                $(".ajax-chapter-dropdown").html(return_data);
                $('.ajax-chapter-dropdown').change();
            }
        });
    });

    $(document).on('change', '.ajax-chapter-dropdown', function () {
        var chapter_id = $(this).val();
        var sub_chapter_id = $(this).attr('data-sub_chapter_id');
        $.ajax({
            type: "GET",
            url: '/admin/webinars/sub_chapters_by_chapter',
            data: {'chapter_id': chapter_id, 'sub_chapter_id': sub_chapter_id},
            success: function (return_data) {
                $(".ajax-subchapter-dropdown").html(return_data);
                $('.ajax-subchapter-dropdown').change();
            }
        });
    });
	
    $(document).on('change', '.ajax-subchapter-dropdown', function () {
		var category_id = $(".ajax-category-courses").val();
		var subject_id  = $(".ajax-courses-dropdown").val();
		var chapter_id  = $(".ajax-chapter-dropdown").val();
		var topics_parts = $(this).attr('data-topics_parts');
        var sub_chapter_id = $(this).val();
        $.ajax({
            type: "GET",
            url: '/admin/webinars/topic_parts_by_sub_chapter',
            data: {'chapter_id': chapter_id, 'sub_chapter_id': sub_chapter_id, 'topics_parts': topics_parts},
            success: function (return_data) {
                $(".topic-parts-options").html(return_data);
            }
        });
    });
	



    $(document).on('click', '#question_preview-tab', function () {
        var question_layout = $(".rureraform-form");
        question_layout.find('.editor-field').each(function () {
            $.each($(this).data(), function (i) {
                if (i != 'style') {
                    question_layout.find('.editor-field').removeAttr("data-" + i);
                }
            });
        });

        question_layout.find('.editor-field').removeAttr("correct_answere");
        $(".question-layout-data").html(question_layout.html());
        var question_score = $("[name=question_score]").val();
        $(".question-layout .marks").html(question_score+' marks');
        var question_layout = rureraform_encode64(JSON.stringify(question_layout.html()));

    });
	
	
	$(document).on('click', '.save-template-btn', function () {
		$(".template_save_modal").modal('hide');
		var template_name = $('.template_name').val();
		var form_data_encoded  = $('.form_data_encoded').val();
        var course_id = $(this).val();
        $.ajax({
            type: "POST",
            url: '/admin/users/save_templates',
            data: {'template_type': 'question_form', 'template_name': template_name, 'form_data_encoded': form_data_encoded},
            success: function (return_data) {
                console.log(return_data);
            }
        });
    });
	
	$(document).on('click', '.save-template', function () {
		// Select all form fields inside the div with id "question_properties"
		$(".template_save_modal").modal('show');
		var formFields = $('#question_properties').find('input, select, textarea');
		// Create an object to store the name-value pairs
		var formData = {};
		// Iterate over each form field
		formFields.each(function() {
			var name = $(this).attr('name');
			var value = $(this).val();

			if (name) {
				formData[name] = value;	
			}
		});
		
		var jsonFormData = JSON.stringify(formData);
		$(".form_data_encoded").val(jsonFormData);
	});
	
	$(document).on('click', '.remove-template', function () {
		// Select all form fields inside the div with id "question_properties"
		var template_name = $(this).attr('data-template_name');
		$(this).closest('li').remove();
		$(".template_display_modal").modal('hide');
        $.ajax({
            type: "POST",
            url: '/admin/users/remove_template',
            data: {'template_type': 'question_form', 'template_name': template_name},
            success: function (return_data) {
                console.log(return_data);
            }
        });
	});
	
	
	
	$(document).on('click', '.activate-template', function () {
		$(".template_display_modal").modal('show');
	});
	
	$(document).on('click', '.apply-template-field li span', function () {
		
		var formDatajson = $(this).closest('li').attr('data-template_data');//'{"category_id[]":["615"],"course_id":"2065","chapter_id":"406","sub_chapter_id":"1107","search_tags":"test","question_title":"Question Reference","question_score":"10","question_average_time":"10","example_question":null,"question_type":"dropdown","difficulty_level":"Emerging","reference_type":"Both"}';
		var formDataObj = JSON.parse(formDatajson);
		$(".template_display_modal").modal('hide');
		
		course_id_template = formDataObj['course_id'];
		chapter_id_template = formDataObj['chapter_id'];
		sub_chapter_id_template = formDataObj['sub_chapter_id'];
		
		is_template_active = true;
		// Select all form fields inside the div with id "question_properties"
		var formFields = $('#question_properties').find('input, select, textarea');

		// Create an object to store the name-value pairs
		var formData = {};

		// Iterate over each form field
		formFields.each(function() {
			var name = $(this).attr('name');
			
			var value = $(this).val(formDataObj[name]);
			
			if ($(this).is('select')) {
				$('select[name="'+name+'"]').change();
			}
			if( name == 'search_tags'){
				if (formDataObj[name].trim()) {
					var tags = formDataObj[name].split(',').map(tag => tag.trim()).filter(tag => tag.length > 0);
					tags.forEach(function(tag) {
						$('input[name="'+name+'"]').tagsinput('add', tag);
					});
				}
			}
		});
	});
	
	
	
	let isProcessing = false;
$(document).off('click', 'body').on('click', 'body', function (event) {
    // Check if the click is not inside .rureraform-properties-content
    if (!$(event.target).closest('.rureraform-properties-content').length && !$(event.target).closest('.rureraform-admin-editor').length) {
        if (!isProcessing) {
            isProcessing = true; // Set the flag to true
            // Check if .rureraform-admin-popup:visible contains .generate-question-code
            if ($('.rureraform-admin-popup:visible').find('.generate-question-code').length > 0) {
                $('.rureraform-admin-popup:visible').find('.generate-question-code').click();
            }
            // Reset the flag after a timeout or after the operation completes
            setTimeout(function() {
                isProcessing = false; // Reset the flag after a delay
            }, 100); // Adjust the timeout duration as needed
        }
    }
});

</script>

@endpush
