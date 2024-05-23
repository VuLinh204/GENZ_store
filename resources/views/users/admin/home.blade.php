 @extends('users.admin.layout.admin')
 @section('css')
     <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
 @endsection
 @section('js')
     <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
     <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
     <script>
         new Morris.Line({
             // ID of the element in which to draw the chart.
             element: 'myfirstchart',
             // Chart data records -- each entry in this array corresponds to a point on
             // the chart.
             data: [{
                     year: '2008',
                     value: 20
                 },
                 {
                     year: '2009',
                     value: 10
                 },
                 {
                     year: '2010',
                     value: 5
                 },
                 {
                     year: '2011',
                     value: 5
                 },
                 {
                     year: '2012',
                     value: 20
                 }
             ],
             // The name of the data record attribute that contains x-values.
             xkey: 'year',
             // A list of names of data record attributes that contain y-values.
             ykeys: ['value'],
             // Labels for the ykeys -- will be displayed when you hover over the
             // chart.
             labels: ['Value']
         });
     </script>

     <script>
         $(document).ready(function() {
             $.ajax({
                 url: "{{ route('admin.statistics') }}",
                 method: 'GET',
                 success: function(data) {
                     console.log(data.totalProducts);
                     $('#totalProducts').text(data.totalProducts);
                     $('#totalCategories').text(data.totalCategories);
                     $('#totalQuantitySold').text(data.totalQuantitySold);
                     $('#mostFavoritedProduct').text(data.mostFavoritedProduct ? data
                         .mostFavoritedProduct.name : 'N/A');
                     $('#categoryWithMostProducts').text(data.categoryWithMostProducts ? data
                         .categoryWithMostProducts.name : 'N/A');
                     $('#userName').text(data.user ? data
                         .user.name : 'N/A');
                 },
                 error: function() {
                     alert('Failed to fetch statistics.');
                 }
             });
         });
     </script>
 @endsection
 <!--Container-->

 @section('content')
     <div class="card-box pd-20 height-100-p mb-30">
         <div class="row align-items-center">
             <div class="col-md-4">
                 <img src="vendors/images/banner-img.png" alt="">
             </div>
             <div class="col-md-8">
                 <h4 class="font-20 weight-500 mb-10 text-capitalize">
                     Chào mừng bạn trở lại 
                     <div class="weight-600 font-30 text-blue"><span id="userName"></span></div>
                 </h4>
                 
             </div>
         </div>
     </div>
     <div class="pd-20 card-box mb-30">
         <div class="row">
             <div class="col-xl-3 mb-30 text-center">
                 <div class="card-box height-100-p widget-style1">
                     <div class="d-flex flex-wrap align-items-center">
                         <div class="widget-data">
                             <div class="h5 mb-0">Tổng số lượng sản phẩm</div>
                             <div class="weight-600 font-25 text-success"><span id="totalProducts"></span></div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-xl-3 mb-30 text-center">
                 <div class="card-box height-100-p widget-style1">
                     <div class="d-flex flex-wrap align-items-center">
                         <div class="widget-data">
                             <div class="h5 mb-0">Các sản phẩm được yêu thích nhất</div>
                             <div class="weight-600 font-25 text-success"><span id="mostFavoritedProduct"></span></div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-xl-3 mb-30 text-center">
                 <div class="card-box height-100-p widget-style1">
                     <div class="d-flex flex-wrap align-items-center">
                         <div class="widget-data">
                             <div class="h5 mb-0">Tổng số lượng danh mục</div>
                             <div class="weight-600 font-25 text-success"><span id="totalCategories"></span></div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-xl-3 mb-30 text-center">
                 <div class="card-box height-100-p widget-style1">
                     <div class="d-flex flex-wrap align-items-center">
                         <div class="widget-data">
                             <div class="h5 mb-0">Danh mục có nhiều sản phẩm mua nhất</div>
                             <div class="weight-600 font-25 text-success"><span id="categoryWithMostProducts"></span></div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>

     </div>
 @endsection
