$(document).on('click','.deleteCategory',function( event ) {
	var catid = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete Category?",
		message: "Do you want to delete the selected category now? All the associated child categories will also be deleted. This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){

				window.location.href = base_url+'/admin/product-categories/delete-category/'+catid;
			}
		}
	});

});

$(document).on('click','.deleteSlide',function( event ) {
	var slideid = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete Slide?",
		message: "Do you want to delete the selected slide now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){

				window.location.href = base_url+'/admin/home-slider/delete-slide/'+slideid;
			}
		}
	});

});

$(document).on('click','.deleteAttribute',function( event ) {
	var attrid = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete Attribute?",
		message: "Do you want to delete the selected attribute now? The selected attribute will also be deleted from associated products. This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){

				window.location.href = base_url+'/admin/products/delete-attribute/'+attrid;
			}
		}
	});

});

$(document).on('click','.deleteProduct',function( event ) {
	var prodid = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete Product?",
		message: "Do you want to delete the selected product now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){
				window.location.href = base_url+'/admin/products/delete/'+prodid;
			}
		}
	});

});




$(document).on('click','.deletePage',function( event ) {
	var prodid = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete Page?",
		message: "Do you want to delete the selected page now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){
				window.location.href = base_url+'/admin/pages/delete/'+prodid;
			}
		}
	});

});

$(document).on('click','.deleteBlog',function( event ) {
	var prodid = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete Blog?",
		message: "Do you want to delete the selected blog now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){
				window.location.href = base_url+'/admin/blogs/delete/'+prodid;
			}
		}
	});

});

$(document).on('click','.deleteBlogCategory',function( event ) {
	var catid = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete Category?",
		message: "Do you want to delete the selected category now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){

				window.location.href = base_url+'/admin/blogs/categories/delete-category/'+catid;
			}
		}
	});

});

$(document).on('click','.deleteBlogComment',function( event ) {
	var catid = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete Comment?",
		message: "Do you want to delete the selected comment now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){

				window.location.href = base_url+'/admin/blogs/comments-list/delete/'+catid;
			}
		}
	});

});


$(document).on('click','.deleteTestimonial',function( event ) {
	var catid = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete Testimonial?",
		message: "Do you want to delete the selected testimonial now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){
				window.location.href = base_url+'/admin/testimonials/delete/'+catid;
			}
		}
	});

});

$(document).on('click','.deleteFaq',function( event ) {
	var catid = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete FAQ?",
		message: "Do you want to delete the selected faq now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){
				window.location.href = base_url+'/admin/faq/delete/'+catid;
			}
		}
	});

});

$(document).on('click','.deleteUser',function( event ) {
	var catid = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete User?",
		message: "Do you want to delete the selected user now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){
				window.location.href = base_url+'/admin/users/delete/'+catid;
			}
		}
	});

});


$(document).on('click','.deleteAdmin',function( event ) {
	var adminId = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete Admin?",
		message: "Do you want to delete the selected admin now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){
				window.location.href = base_url+'/admin/admin/delete/'+adminId;
			}
		}
	});

});


$(document).on('click','.deleteCoupon',function( event ) {
	var catid = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete Coupon?",
		message: "Do you want to delete the selected coupon now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){
				window.location.href = base_url+'/admin/coupon-manager/delete/'+catid;
			}
		}
	});

});

$(document).on('click','.deleteTag',function( event ) {
	var catid = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete Tag?",
		message: "Do you want to delete the selected tag now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){
				window.location.href = base_url+'/admin/products/tags/delete-tag/'+catid;
			}
		}
	});

});

// Delete Store Gallery Images

$('.img-wrap .delete_image').on('click', function() {
	var tt = $(this).closest('.img-wrap');
	var id = tt.find('img').data('id');

	bootbox.confirm({
		title: "Delete Gallery Image?",
		message: "Do you want to delete the selected image now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){
				//window.location.href = base_url+'/admin/products/delete-image/'+id;
				$.ajax({
					type: "GET",
					data: {
						productImage: 'delete',
					},
					url: base_url+'/admin/stores/delete-image/'+id,
					success: function(data) {
						if(data == "success") {
							tt.remove();
						}
					}
				});
			}
		}
	});
});

$(document).on('click','.deleteOrder',function( event ) {
	var catid = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete Order?",
		message: "Do you want to delete the selected order now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){
				window.location.href = base_url+'/admin/orders/delete/'+catid;
			}
		}
	});

});

$(document).on('click','.deleteType',function( event ) {
	var catid = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete Product Type?",
		message: "Do you want to delete the selected type now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){
				window.location.href = base_url+'/admin/products/delete-type/'+catid;
			}
		}
	});

});

$(document).on('click','.deleteSubscription',function( event ) {
	var catid = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete Newsletter Subscription?",
		message: "Do you want to delete the selected subscription now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){
				window.location.href = base_url+'/admin/newsletter-subscription/delete-subscription/'+catid;
			}
		}
	});

});

$(document).on('click','.update_points',function( event ) {
	var userid = $(this).attr('data-user-id');
	var points = $('#user_points_'+userid).val();
	var el = $(this);

	el.find('i').addClass('fa-spin fa-refresh');
	el.find('i').removeClass('fa-edit');
	el.addClass('disabled').removeAttr("href");
	//aa.find('i').toggleClass('fa fa-spin fa-refresh');
	//aa.text('<i class="fa fa-spin fa-refresh"></i> LOADING');
	$.ajax({
		url: base_url + '/admin/points-and-rewards/update-points',
		type: 'POST',
		data: { user : userid, points:points },
		datatype: 'json',
		headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },

		success: function(data){
			if(data.status && data.status == 'success' && data.msg){
				swal("Success!", data.msg, "success");
				el.find('i').removeClass('fa-spin fa-refresh');
				el.find('i').addClass('fa-edit');
				el.removeClass("disabled").attr("href", "javascript:;");
				$('span.user_points_'+userid).text(data.points);
				//aa.text('<i class="fa fa-edit"></i> UPDATE');
				return false;
			}

			if(data.status && data.status == 'warning' && data.msg){
				swal(data.msg);
				el.find('i').removeClass('fa-spin fa-refresh');
				el.find('i').addClass('fa-edit');
				el.removeClass("disabled").attr("href", "javascript:;");
				//aa.text('<i class="fa fa-edit"></i> UPDATE');
				return false;
			}

		},
		error:function(){}
	});

});

// Blogs Tag Delete

$(document).on('click','.deleteBlogTag',function( event ) {
	var tagid = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete Tag?",
		message: "Do you want to delete the selected tag now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){
				window.location.href = base_url+'/admin/blogs/tags/delete-tag/'+tagid;
			}
		}
	});

});

// Team Delete

$(document).on('click','.deleteTeam',function( event ) {
	var teamid = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete Tag?",
		message: "Do you want to delete the selected Team now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){
				window.location.href = base_url+'/admin/team/delete/'+teamid;
			}
		}
	});

});

// Review Delete
$(document).on('click','.deleteReview',function( event ) {
	var reviewid = $(this).attr('data-id');
	//alert(base_url+'/admin/review/delete/'+reviewid);
	bootbox.confirm({
		title: "Delete Review?",
		message: "Do you want to delete the selected Review now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){
				window.location.href = base_url+'/admin/review/delete/'+reviewid;
			}
		}
	});

});

// Contact Delete

$(document).on('click','.deleteContact',function( event ) {
	var contactid = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete Tag?",
		message: "Do you want to delete the selected Contact now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){
				window.location.href = base_url+'/admin/contact/delete/'+contactid;
			}
		}
	});

});

// Delete Coupon Type

$(document).on('click','.deleteCouponType',function( event ) {
	var cTypeid = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete Coupon Type?",
		message: "Do you want to delete the selected Coupon Type now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){
				window.location.href = base_url+'/admin/coupons/delete-type/'+cTypeid;
			}
		}
	});

});

// Delete Video Guide

$(document).on('click','.deleteVideoGuide',function( event ) {
	var videoid = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete Video Guide?",
		message: "Do you want to delete the selected Video Guide now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){
				window.location.href = base_url+'/admin/guide/video/delete/'+videoid;
			}
		}
	});

});

// Delete Guide

$(document).on('click','.deleteGuide',function( event ) {
	var guideId = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete Guide?",
		message: "Do you want to delete the selected Guide now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){
				window.location.href = base_url+'/admin/guide/delete/'+guideId;
			}
		}
	});

});

// Delete Delivery Setting

$(document).on('click','.deleteDeliverySetting',function( event ) {
	var contactid = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete Setting?",
		message: "Do you want to delete the selected Setting now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){
				window.location.href = base_url+'/admin/delivery/delete/'+contactid;
			}
		}
	});

});

// Delete Store

$(document).on('click','.deleteStore',function( event ) {
	var contactid = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete Store?",
		message: "Do you want to delete the selected Store now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){
				window.location.href = base_url+'/admin/store/delete/'+contactid;
			}
		}
	});

});

// Delete Coupons

$(document).on('click','.deleteStoreCoupon',function( event ) {
	var contactid = $(this).attr('data-id');
	bootbox.confirm({
		title: "Delete Coupon?",
		message: "Do you want to delete the selected Coupon now? This cannot be undone.",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			}
		},
		callback: function (result) {
			if(result){
				window.location.href = base_url+'/admin/coupon/delete/'+contactid;
			}
		}
	});

});