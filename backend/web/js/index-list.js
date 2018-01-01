/**
 * Created by Administrator on 2016/4/12.
 */
$(function(){
	$("#delete-btn").click(function(){
		if(confirm('您确定要删除 ,这是不可恢复操作')){
			$("#dltForm").submit();
		}
	});

	$(".data_delete").click(function(){
		$("#dltForm").find('input[type=checkbox]').prop('checked' , false);
		$(this).parent().parent().find('input[type=checkbox]').prop('checked' , true);
		$("#delete-btn").click();
	});
});