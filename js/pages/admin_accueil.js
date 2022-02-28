jQuery(document).ready(function() {

    $('.datetimepicker').datetimepicker({
        locale: 'fr',
        format: 'DD/MM/YYYY',
        ignoreReadonly: true
    });
});

    //$('.start_date').prop('disabled',true)

    /*$('.datetimepicker').on('keyup',function(e){
        e.preventDefault();

        return false;
    })*/

//     var yesterday = new Date();
//     yesterday.setDate(yesterday.getDate() - 1);
//     var thirty_days_ago = new Date();
//     thirty_days_ago.setDate(thirty_days_ago.getDate() - 30);

//     /*PREMIER GRAPHIQUE*/
//     var labels = $('#graph1').data('dates');
//     var sessions = $('#graph1').data('sessions');

//     var users = $('#graph1').data('users');
//     var pageviews = $('#graph1').data('pageviews');
//     var ctx = document.getElementById("myChart");
//     var myChart = new Chart(ctx, {
//         type: 'line',
//         data: {
//             labels: labels,
//             datasets: [{
//                 label: 'Sessions',
//                 backgroundColor: "#cc5f5f",
//                 borderColor: "#bc0101",
//                 fill:false,
//                 data: sessions
//             },{
//                 label: 'Utilisateurs',
//                 backgroundColor: "#a1e2a1",
//                 borderColor: "#42c442",
//                 fill:false,
//                 data: users
//             },{
//                 label: 'Pages vues',
//                 backgroundColor: "#a3e4ff",
//                 borderColor: "#00b6ff",
//                 fill:false,
//                 data: pageviews
//             }]
//         },
//         options:{
//             scales: {
//                 xAxes: [{
//                     gridLines: {
//                         drawOnChartArea: true
//                     }
//                 }]
//             },
//             legend: {
//                 position: 'left'
//             }

//         }
//     });

//     var labels2 = $('#graph2').data('dates');
//     var jsdatas = $('#graph2').data('js');

//     var ctx2 = document.getElementById("myChart2");
//     var myChart2 = new Chart(ctx2, {
//         type: 'line',
//         data: {
//             labels: labels2,
//             datasets: jsdatas
//         },
//         options:{
//             scales: {
//                 xAxes: [{
//                     gridLines: {
//                         drawOnChartArea: true
//                     }
//                 }]
//             },
//             legend: {
//                 position: 'left'
//             }
//         }
//     });


//     $('input[name=data_type]').on('click',function(){
//         chart_update(myChart2,'_bis');
//     });
//     $('input[name=view_bis]').on('click',function(){
//         chart_update(myChart2,'_bis');
//     });
//     $('input[name=view]').on('click',function(){
//         chart_update(myChart);
//     });
//     $('#datetimepicker1').on('change.datetimepicker', function(e) {
//         if (e.oldDate !== null){
//             chart_update(myChart);
//         }
//         return false;
//     });
//     $('#datetimepicker2').on('change.datetimepicker', function(e) {
//         if (e.oldDate !== null){
//             chart_update(myChart);
//         }
//         return false;
//     });
//     $('#datetimepicker3').on('change.datetimepicker', function(e) {
//         if (e.oldDate !== null){
//             chart_update(myChart2,'_bis');
//         }
//         return false;
//     });
//     $('#datetimepicker4').on('change.datetimepicker', function(e) {
//         if (e.oldDate !== null){
//             chart_update(myChart2,'_bis');
//         }
//         return false;
//     });


//     function chart_update(updateChart,id=''){
//         var start_date = $('.start_date'+id+'').val();
//         var end_date = $('.end_date'+id+'').val();
//         var view = $('input[name=view'+id+']:checked').val();
//         if(start_date != '' && end_date != ''){
//             if(id=='_bis'){
//                 data_type = $('input[name=data_type]:checked').val();
//                 url_ajax = 'ajax_analytics_data_2';
//                 data = {'start' : start_date, 'end' : end_date, 'view' : view, 'data_type' : data_type};
//             }
//             else{
//                 url_ajax = 'ajax_analytics_data';
//                 data = {'start' : start_date, 'end' : end_date, 'view' : view};
//             }
//             $.ajax({
//                 url: url_ajax,
//                 type: 'post',
//                 dataType: "json",
//                 data: data,
//                 complete: function(){
//                     $('#loading').hide();
//                 },
//                 success: function(data){
//                     if(id=='_bis'){
//                         updateChart.data.datasets = data.data;
//                         updateChart.data.labels = data.dates;
//                         updateChart.update();
//                     }
//                     else{
//                         updateChart.data.datasets[0].data = data.sessions;
//                         updateChart.data.datasets[1].data = data.users;
//                         updateChart.data.datasets[2].data = data.pageviews;
//                         updateChart.data.labels = data.dates;
//                         updateChart.update();
//                     }

//                 }
//             });
//         }
//     }

// })