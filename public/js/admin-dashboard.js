jQuery(document).ready(function(){
 jQuery('#form-report-monthly').submit(function(){
    var form = jQuery(this);
    submit_cart(form,'btn-month')
    return false;
  })

 jQuery('#form-report-yearly').submit(function(){
    var form = jQuery(this);
    submit_cart(form,'btn-year')
    return false;
 })


 jQuery('#form-report-monthly').submit()
 jQuery('#form-report-yearly').submit()
})

var state = 0;
function submit_cart(form,btn_id){
  //var form = jQuery(id);
  if(state==0){
    state=1;

    var formdata = false;
    if (window.FormData){
        formdata = new FormData(form[0]);
    }
    

    var formAction = form.attr('action');
    jQuery('#'+btn_id).text('Mohon Menunggu...')

    jQuery.ajax({
        url         : jQuery(form).prop("action"),
        data        : formdata ? formdata : form.serialize(),
        cache       : false,
        contentType : false,
        processData : false,
        type        : 'POST',
        success     : function(data, textStatus, jqXHR){
            var res = jQuery.parseJSON(data)
            if(res.status=='success'){
              set_chart(res.div, res.date, res.total, res.total_profit, res.access, res.limit)
            }else{
              var class_alert = 'alert alert-danger';
              jQuery('#alert').attr('class',class_alert);
              jQuery('#middle-alert').html(res.msg);
              jQuery('#alert-form').slideDown(600);
            }
            
            setTimeout(function(){
              jQuery('#alert-form').slideUp(600)  
            },6000)
            state=0;
            jQuery('#'+btn_id).text('Tampilkan')                
            return false;
        }
    });  
  }

  
  return false;
}



function set_manual(){
  var div = 'lineChartMonth'
  var date = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31]
  var total = [500000,400000,540000,700000,500000,450000,500000,600000,900000,400000,
                400000,300000,440000,600000,400000,350000,400000,500000,800000,300000,
                500000,400000,540000,700000,500000,450000,500000,600000,900000,400000, 500000
                ]
  var total_profit = [250000,200000,210000,350000,250000,300000,200000,300000,450000,100000,
                      150000,100000,110000,250000,150000,200000,100000,250000,150000, 200000,
                      250000,200000,210000,350000,250000,300000,200000,300000,250000, 100000, 250000]

  var access = 'admin';
  var limit = '1000000';
  set_chart(div,date,total,total_profit,access,limit)
} 






function set_chart(div,date,value,profit,access,limit){
  if ($("#"+div).length) {
      var lineChart = $("#"+div);

      // line chart data      
      if(access=='admin'){
        var lineData = {
                            labels: date,
                                    datasets: [
                                                {
                                                  label: "Penjualan",
                                                  data: value,
                                                  borderColor: "#3e95cd",
                                                  fill: false
                                                },
                                                {
                                                  label: "Keuntungan",
                                                  data: profit,
                                                  backgroundColor: '#ffffff',
                                                  borderColor: '#4bc0c0',
                                                  borderDash: [5, 5],
                                                  fill: false
                                                }
                                              ]
                                    
                          };

      }else{
          var lineData = {
                            labels: date,
                                    datasets: [
                                                {
                                                  label: "Penjualan",
                                                  data: value,
                                                  borderColor: "#3e95cd",
                                                  fill: false
                                                }
                                              ]
                                    
                          };
      }

      /*window.onload = function() {
          var ctx = document.getElementById("canvas").getContext("2d");
          window.myLine = new Chart(ctx, config);
      };*/


      // line chart init
      var myLineChart = new Chart(lineChart, {
        type: 'line',
        data: lineData,
        options: {
          tooltips: {
              callbacks: {
                  label: function(tooltipItem, data) {
                    var label = data.datasets[tooltipItem.datasetIndex].label || '';
                    
                    value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                    value = value.toString();
                    value = value.split(/(?=(?:...)*$)/);
                    value = value.join('.');

                    return label+': '+value;
                  }
              }
          },


          legend: {
            display: false
          },
          scales: {
            xAxes: [{
              ticks: {
                fontSize: '11',
                fontColor: '#969da5',
              },
              gridLines: {
                color: 'rgba(0,0,0,0.05)',
                zeroLineColor: 'rgba(0,0,0,0.05)'
              }
            }],
            yAxes: [{
              display: true,
              ticks: {
                beginAtZero: true,
                max: limit,
                userCallback: function(value, index, values) {
                  // Convert the number to a string and splite the string every 3 charaters from the end
                  value = value.toString();
                  value = value.split(/(?=(?:...)*$)/);
                  
                  
                  value = value.join('.');
                  return value;
                }
              }
              
            }]
          }
        }
      });
  }
}