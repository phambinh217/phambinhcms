<div class="table-function-container">
	@if (isset($filter))
		<div class="portlet light bordered filter">
		    <div class="portlet-title">
		        <div class="caption">
		            <i class="fa fa-filter"></i> @lang('cms.filter-result')
		        </div>
		        <div class="tools">
		        	<a href="javascript:;" class="collapse" data-original-title="" title=""></a>
		        </div>
		    </div>
		    <div class="portlet-body form">
		        <form action="#" class="form-horizontal form-bordered form-row-stripped">
		            <div class="form-body">
		                {!! $filter !!}
		            </div>
		            <div class="form-actions util-btn-margin-bottom-5">
		                <div class="row">
		                    <div class="col-md-12 text-right">
		                    	<button type="submit" class="btn btn-primary full-width-xs">
		                    		<i class="fa fa-filter"></i> @lang('cms.filter')
		                    	</button>
		                    	<a href="{{ $url or request()->url() }}" class="btn btn-gray full-width-xs">
		                    		<i class="fa fa-times"></i> @lang('cms.cancel')
		                    	</a>
		                    </div>
		                </div>
		            </div>
		        </form>
		    </div>
		</div>
	@endif

	@if (isset($total))
		<div class="note note-success">
			<p><i class="fa fa-info"></i> @lang('cms.total-result-are', ['total' => $total])</p>
		</div>
	@endif

	<div class="row table-above">
	    <div class="col-sm-6">
	    	<div class="form-inline mb-10 form-function">
	    		@if (isset($bulkactions))
		    		<div class="form-group">
		    			<select class="form-control multiple-function">
		    				<option></option>
		    				@foreach($bulkactions as $action)
		    					<option data-method="{{ $action['method'] or '' }}" value="{{ $action['action'] }}">{{ $action['name'] }}</option>
		    				@endforeach
		    			</select>
		    		</div>
		    		<div class="form-group">
		    			<button class="btn btn-default btn-apply full-width-xs">@lang('cms.apply')</button>
		    		</div>
		    	@endif
		    </div>
	    </div>
	    <div class="col-sm-6 text-right table-page">
	    	@if (isset($paginate))
	    		{!! $paginate !!}
	    	@endif
	    </div>
    </div>

    <div class="table-responsive main">
		<table id="master-table" class="master-table table table-striped table-hover table-checkable order-column pb-users">
			<thead>
				<tr class="noExl">
					{!! $heading !!}
				</tr>
			</thead>
			<tbody>
				{!! $data !!}
			</tbody>
			<tfoot>
				<tr>
					{!! $heading !!}
				</tr>
			</tfoot>
		</table>
	</div>
	
	@if (isset($bulkactions) || isset($paginate))
		<div class="row table-after">
		    <div class="col-sm-6">
		    	<div class="form-inline mb-10 form-function">
		    		@if (isset($bulkactions))
			    		<div class="form-group">
			    			<select class="form-control multiple-function">
			    				<option></option>
			    				@foreach($bulkactions as $action)
			    					<option data-method="{{ $action['method'] or '' }}" value="{{ $action['action'] }}">{{ $action['name'] }}</option>
			    				@endforeach
			    			</select>
			    		</div>
			    		<div class="form-group">
			    			<button class="btn btn-default btn-apply full-width-xs">Áp dụng</button>
			    		</div>
			    	@endif
			    </div>
		    </div>
		    <div class="col-sm-6 text-right table-page">
		    	@if (isset($paginate))
		    		{!! $paginate !!}
		    	@endif
		    </div>
	    </div>
    @endif
</div>

@addCss('css', asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.css'))
@addJs('js_footer', asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.js'))
