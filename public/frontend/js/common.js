function range(start, end) {
  var ans = [];
  for (let i = start; i <= end; i++) {
    ans.push(i);
  }
  return ans;
}

function viewWinnerDetail(id) {
	$.ajax({
		type: 'GET',
		url: $('#url-winner-detail').val() + '/'+id,
		success: function(rsp) {
			$('#modal-winner-detail #modal-image').attr('src', rsp.image);
			$('#modal-winner-detail #winner-name').text(rsp.name);
			$('#modal-winner-detail #prize').text(rsp.prize);
			$('#modal-winner-detail #description').text(rsp.description);
			$('#modal-winner-detail').modal('show');
			
		}
	});
}