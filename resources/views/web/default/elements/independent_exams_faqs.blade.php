@php $faq_items =  isset( $faq_items )? $faq_items : array();@endphp
<section class="py-70" style="background-color: #fff">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-title text-center mb-30">
					<h2 class="mt-0 mb-10 font-40">Frequently Asked Questions for Independent exams.</h2>
				</div>
			</div>
			<div class="col-12 col-lg-12 col-md-12 mx-auto">
				<div class="mt-0">
					<div class="lms-faqs mx-w-100 mt-0">
						<div id="accordion">
							@if( !empty( $faq_items ))
								
								@foreach( $faq_items as $itemData)
									<div class="card">
										<div class="card-header" id="headingonsix">
											<h3 class="mb-0">
												<button class="btn btn-link font-18 font-weight-bold" data-toggle="collapse" data-target="#collapsesix" aria-expanded="true" aria-controls="collapsesix">{{isset( $itemData['title'])? $itemData['title'] : '' }}</button>
											</h3>
										</div>
										<div id="collapsesix" class="collapse" aria-labelledby="headingsix"
											data-parent="#accordion">
											<div class="card-body"><p>{{isset( $itemData['description'])? $itemData['description'] : '' }}</p></div>
										</div>
									</div>
								@endforeach
							
								@else 
								<div class="card">
									<div class="card-header" id="headingonsix">
										<h3 class="mb-0">
											<button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapsesix" aria-expanded="true" aria-controls="collapsesix">What is the difference between grammar school and independent school entrance exams?</button>
										</h3>
									</div>
									<div id="collapsesix" class="collapse" aria-labelledby="headingsix"
										data-parent="#accordion">
										<div class="card-body"><p>Grammar School Entrance Exams typically focus on assessing academic skills in English, mathematics, and reasoning to determine eligibility for state-funded schools. Independent School Entrance Exams, on the other hand, may cover a broader range of subjects and skills, including sciences and sometimes additional assessments, reflecting the private nature of the institutions.</p></div>
									</div>
								</div>
								<div class="card">
									<div class="card-header" id="headingTwo">
										<h3 class="mb-0"><button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse"
												data-target="#collapseTwo" aria-expanded="false"
												aria-controls="collapseTwo">How can I prepare for an independent school entrance exam?</button></h3>
									</div>
									<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
										data-parent="#accordion">
										<div class="card-body"><p>To get ready for your test, you should start with preparing by familiarizing yourself with the exam format, practicing past papers, focusing on key subjects, and using targeted study resources.Doing these things can help you feel prepared and confident!</p></div>
									</div>
								</div>
								<div class="card">
									<div class="card-header" id="headingseven">
										<h3 class="mb-0">
											<button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapseseven" aria-expanded="false" aria-controls="collapseseven">How can Rurera help me in preparing for independent school exams?</button>
										</h3>
									</div>
									<div id="collapseseven" class="collapse" aria-labelledby="headingseven" data-parent="#accordion">
										<div class="card-body"><p>Rurera offers a wide range of resources to help you prepare for independent school exams. We provide practice tests to familiarize you with exam formats, study guides that cover key topics, and personalized support to address your specific needs and improve your performance.</p></div>
									</div>
								</div>
								<div class="card">
									<div class="card-header" id="heading8">
										<h3 class="mb-0">
											<button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8">When are independent and entrance exams typically held?</button>
										</h3>
									</div>
									<div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordion">
										<div class="card-body"><p>Exam dates can vary based on the institution and the type of exam being administered. For the most precise and current information, it's best to visit the specific institution’s website or reach out to them directly to confirm the exact exam schedule. This ensures that you are aware of any changes or updates that might affect important deadlines or testing dates.</p></div>
									</div>
								</div>
								<div class="card">
									<div class="card-header" id="heading9">
										<h3 class="mb-0">
											<button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9">What subjects are commonly covered in independent entrance exams?</button>
										</h3>
									</div>
									<div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#accordion">
										<div class="card-body"><p>The most common subjects for these exams typically include mathematics, English, and science, forming the core of the curriculum. In addition to these, many exams also assess reasoning skills, particularly in verbal and non-verbal reasoning. Depending on the institution’s specific requirements, additional subjects may be covered, offering a broader scope that could include topics like history, geography, or modern languages.</p></div>
									</div>
								</div>
								<div class="card">
									<div class="card-header" id="heading10">
										<h3 class="mb-0">
											<button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse10" aria-expanded="false" aria-controls="collapse10">Are there practice resources available for these exams on Rurera?</button>
										</h3>
									</div>
									<div id="collapse10" class="collapse" aria-labelledby="heading10" data-parent="#accordion">
										<div class="card-body"><p>Yes, Rurera provides a variety of practice materials and resources designed to support your exam preparation. This includes practice tests, study guides, and interactive tools to help you understand key concepts and improve your performance.</p></div>
									</div>
								</div>
								<div class="card">
									<div class="card-header" id="heading11">
										<h3 class="mb-0">
											<button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse11" aria-expanded="false" aria-controls="collapse11">Are there any tips on how to make the most of Rurera’s resources?</button>
										</h3>
									</div>
									<div id="collapse11" class="collapse" aria-labelledby="heading11" data-parent="#accordion">
										<div class="card-body"><p>To make the most of Rurera’s resources, regularly use practice tests to assess your skills, follow the study guides to review key concepts, and take advantage of personalized feedback to focus on areas that need improvement.</p></div>
									</div>
								</div>
								<div class="card">
									<div class="card-header" id="heading11">
										<h3 class="mb-0">
											<button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse11" aria-expanded="false" aria-controls="collapse11">How can I track my progress while preparing for these exams?</button>
										</h3>
									</div>
									<div id="collapse11" class="collapse" aria-labelledby="heading11" data-parent="#accordion">
										<div class="card-body"><p>Utilize Rurera’s tools and assessments to track your progress over time and pinpoint specific areas where you may need additional practice. Our comprehensive feedback helps you focus on areas for improvement and maximize your study efforts.</p></div>
									</div>
								</div>
									
							@endif
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>