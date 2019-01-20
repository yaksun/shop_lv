@extends('layouts.admin')
@section('content')
    <input type="button" value="确认" onclick="showTab()">
    <script>
       
       function showTab() {
           //tab层

           $.post("{{url('admin/showtab')}}",{'_token':'{{csrf_token()}}'},function (data) {
              if(data.msg==0){
                  layer.tab({
                      area: ['600px', '300px'],
                      tab: [
                          {
                              title: 'TAB1',
                              content: '<table id="tab1"><tr><td>姓名</td><td>年龄</td></tr>' +
                              '<tr><td></td><td></td></tr></table>'
                          }
                          ]
                  })
              }
           });
           /*layer.tab({
               area: ['600px', '300px'],
               tab: [
                   {
                   title: 'TAB1',
                   content: '<table id="tab1"><tr><td>姓名</td><td>年龄</td></tr>' +
                   '<tr><td>yaksun</td><td>30</td></tr></table>'
               }/!*, {
                   title: 'TAB2',
                   content: ''
               }, {
                   title: 'TAB3',
                   content: '内容3'
               }*!/
               ]
           });*/
       }
    </script>
    <style>
        #tab1{
           
        }
    </style>
@endsection
