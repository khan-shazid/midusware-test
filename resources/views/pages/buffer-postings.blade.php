@extends('layouts.app')
@section('content')
<div class="container-fluid app-body">
	<h3>Recent Posts Sent To Buffer
	</h3>

	<hr />

	<div class="row">
		<div class="col-md-4">
			<input class="search-text form-control" type="text" />
		</div>
		<div class="col-md-4">
			<input class="filter filter-date form-control" type="date" />
		</div>
		<div class="col-md-4">
			<select class="filter filter-group form-control" id="groupId">
			  <option value="volvo">Volvo</option>
			  <option value="saab">Saab</option>
			  <option value="mercedes">Mercedes</option>
			  <option value="audi">Audi</option>
			</select>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<table class="datatable table table-hover social-accounts">
				<thead>
					<tr>
						<th>Group Name</th>
						<th>Group Type</th>
						<th>Account Name</th>
						<th>Post Text</th>
						<th>Time</th>
					</tr>
				</thead>
				<tbody id="set-ajax-data">
				</tbody>
			</table>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12" id="pagination">
			<div class="btn-group" role="group" aria-label="Basic example">
			</div>
		</div>
	</div>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
	var page = 1;
	filterData()
	// $.ajax({
	// 	url: "/filter-buffer-postings",
	// 	success: function(result){
	// 		// $("#div1").html(result);
	// 		console.log(result.current_page)
	// 	}
	// });
	$('.search-text').on("input change", function(){
		 page = 1;
		 filterData($('.search-text').val(),$('.filter-date').val(),$('.filter-group').val(),page)
  });

	$('.filter').on("change", function(){
		 page = 1;
		 filterData($('.search-text').val(),$('.filter-date').val(),$('.filter-group').val(),page)
  });

	function filterData(str = '',date = '',groupId = '',page = 1){
		let queryParams = 'search='+str+'&date='+date+'&groupId='+groupId+'&page='+page;
		console.log("queryParams",queryParams);
		$.ajax({
			url: "/filter-buffer-postings?",
			success: function(result){
	      // $("#div1").html(result);
				console.log(result)
				let htmlResult = '';
				if(result.data && result.data.length){
					result.data.forEach(function(item,i){
						htmlResult += '<tr>'+
													'<td>'+item.group_info.name+'</td>'+
													'<td>'+item.group_info.type+'</td>'+
													'<td>'+item.account_info.name+'</td>'+
													'<td>'+item.post_text+'</td>'+
													'<td>'+item.created_at+'</td>'+
											'</tr>'

					})
				}
				$('#set-ajax-data').html(htmlResult);
				let paginationResult = '';
				if(result.last_page){
					for(let i = 0; i < result.last_page; i++){
						if(i+1==result.current_page){
							paginationResult += '<button class="btn btn-success">'+(i+1)+'</button>';
						}else{
							paginationResult += '<button class="btn btn-info">'+(i+1)+'</button>';
						}
					}
				}
				$('#pagination').html(paginationResult);
	    }
		});
	}
});
</script>
@endsection
