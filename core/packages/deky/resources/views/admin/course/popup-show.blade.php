<div class="modal fade" id="popup-show-course">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Modal title</h4>
			</div>
			<div class="modal-body">
				<div role="tabpanel">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active">
							<a href="#intro-link" aria-controls="intro-link" role="tab" data-toggle="tab">Link giới thiệu</a>
						</li>
						<li role="presentation">
							<a href="#content" aria-controls="content" role="tab" data-toggle="tab">Nội dung</a>
						</li>
					</ul>
				
					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="intro-link">
							<div class="note note-info note-bordered">
						        <p>Sửa dụng link bên dưới để giới thiệu khóa học <br />
						        Học viên đăng ký bằng link này sẽ được tính là bạn giới thiệu</p>
						    </div>
					        <div class="form-horizontal">
				        		<div class="form-group">
				        			<label class="col-sm-3 control-label">Link giới thiệu</label>
				        			<div class="col-sm-9">
				        				<input type="" name="" class="form-control" readonly value="{{ my_ref_code_url(route('course.show', ['slug' => $course->slug, 'id' => $course->id])) }}" />
				        			</div>
				        		</div>
					        </div>
						</div>
						<div role="tabpanel" class="tab-pane" id="content">...</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary full-width-xs" data-dismiss="modal">Đóng</button>
			</div>
		</div>
	</div>
</div>