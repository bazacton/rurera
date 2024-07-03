@php $faq_items =  isset( $faq_items )? $faq_items : array();@endphp
<section class="py-70" style="background-color: #fff">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-title text-center mb-30">
					<h2 class="mt-0 mb-10 font-40">Frequently asked questions</h2>
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
											<button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapsesix" aria-expanded="true" aria-controls="collapsesix">What is the 11 Plus exam?</button>
										</h3>
									</div>
									<div id="collapsesix" class="collapse" aria-labelledby="headingsix"
										data-parent="#accordion">
										<div class="card-body"><p>The 11 Plus exam is a selective entrance examination taken by students around the age of 10 or 11 in uk.
										It assesses students' aptitude in key subjects to determine their suitability for admission to selective
										secondary schools or grammar schools</p></div>
									</div>
								</div>
								<div class="card">
									<div class="card-header" id="headingTwo">
										<h3 class="mb-0"><button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse"
												data-target="#collapseTwo" aria-expanded="false"
												aria-controls="collapseTwo">What subjects are covered in the 11 Plus exam?</button></h3>
									</div>
									<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
										data-parent="#accordion">
										<div class="card-body"><p>The 11 Plus exam typically includes English comprehension, grammar, vocabulary, creative writing,
										mathematics, and reasoning skills.</p></div>
									</div>
								</div>
								<div class="card">
									<div class="card-header" id="headingseven">
										<h3 class="mb-0">
											<button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapseseven" aria-expanded="false" aria-controls="collapseseven">How do I prepare my child for the 11 Plus exam?</button>
										</h3>
									</div>
									<div id="collapseseven" class="collapse" aria-labelledby="headingseven" data-parent="#accordion">
										<div class="card-body"><p>Preparation for the 11 Plus exam usually involves a combination of practice materials, and
										familiarization with the exam format. Solving past papers, improving time management skills, and
										receiving targeted coaching are common preparation methods</p></div>
									</div>
								</div>
								<div class="card">
									<div class="card-header" id="heading8">
										<h3 class="mb-0">
											<button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8">When should my child start preparing for the 11 Plus exam?</button>
										</h3>
									</div>
									<div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordion">
										<div class="card-body"><p>The ideal preparation time for the 11 Plus exam varies depending on the child and their academic
										progress.</p></div>
									</div>
								</div>
								<div class="card">
									<div class="card-header" id="heading9">
										<h3 class="mb-0">
											<button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9">Are there different types of 11 Plus exams?</button>
										</h3>
									</div>
									<div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#accordion">
										<div class="card-body"><p>Yes, there are different types of 11 Plus exams conducted by various exam boards or organizations. The
										content, format, and style of questions may vary between regions and schools. It's important to
										research and understand the specific requirements of the schools your child is interested in.</p></div>
									</div>
								</div>
								<div class="card">
									<div class="card-header" id="heading10">
										<h3 class="mb-0">
											<button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse10" aria-expanded="false" aria-controls="collapse10">Can my child retake the 11 Plus exam if they don't pass?</button>
										</h3>
									</div>
									<div id="collapse10" class="collapse" aria-labelledby="heading10" data-parent="#accordion">
										<div class="card-body"><p>The policies regarding retaking the 11 Plus exam vary depending on the region and school. Some schools
										allow students to retake the exam, while others do not. It is advisable to check with the individual
										schools or local education authorities for their specific retake policies.</p></div>
									</div>
								</div>
								<div class="card">
									<div class="card-header" id="heading11">
										<h3 class="mb-0">
											<button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse11" aria-expanded="false" aria-controls="collapse11">What happens if my child passes the 11 Plus exam?</button>
										</h3>
									</div>
									<div id="collapse11" class="collapse" aria-labelledby="heading11" data-parent="#accordion">
										<div class="card-body"><p>If your child passes the 11 Plus exam, they may be eligible for admission to selective secondary schools
										or grammar schools. However, admission is not solely based on exam results and may also consider
										other factors such as school capacity and distance from your home</p></div>
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