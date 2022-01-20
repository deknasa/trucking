function NavigateNext(sgrid) {
	var gridArr = $(sgrid).getDataIDs();
	var selrow = $(sgrid).getGridParam("selrow");
	var curr_index = 0;
	for (var i = 0; i < gridArr.length; i++) {
		if (gridArr[i] == selrow){
			curr_index = i;
		}
	}
	if ((curr_index + 1) < gridArr.length){
		$(sgrid).resetSelection().setSelection(gridArr[curr_index + 1], true);
		var dataid = $(sgrid).jqGrid('getGridParam','selrow');
		return dataid;
	}else{
		if ((curr_index - 1) >= 0){
			$(sgrid).resetSelection().setSelection(gridArr[curr_index - 1], true);
			var dataid = $(sgrid).jqGrid('getGridParam','selrow');
			return dataid;
		}
	}
}