<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>[SUBJECT]</title>
 </head>
 <body style="    font-family: system-ui;">
  
    <!--  =========================== The header ===========================  -->   
    
 

    <table style="max-width: 600px; margin: 0 auto; display: block; border:1px solid #e8e8e8">
      <thead style="    width: 100%;    display: block;    text-align: center;">
        <tr style="    width: 100%;    display: block; " >
          <th style="text-align: center; width: 100% ; display: block; background: #fbd4c5; margin-left: -1px ">
            <h2><img src="{{asset('public/frontend/images/logo.png')}}" style="width: 200px;"></h2>
          </th>
        </tr>
      </thead>
      <tbody style="    width: 100%;    display: block; background: url(images/back.png); background-size: cover; background-repeat: no-repeat; background-position: center;">
        <tr style="    width: 100%;    display: block;">
          <td style="    width: 100%;    display: block;">
              <p style="margin: 0; font-size: 21px; font-weight: 600;  padding: 20px 15px 8px 15px;" >Dear, {{@$data['name']}} {{@$data['last_name']}}</p>
          </td>
        </tr>
        <tr style="    width: 100%;    display: block;">
          <td style="    width: 100%;    display: block;">
            <p style="margin: 0; font-size: 17px; font-weight: 400;   padding: 5px 15px 5px 15px;">Your final puja link for "{{@$data['puja']}} " on <span style="color: #fbbc93; font-weight: 500;">{{@$data['date']}}</span> and order id is "{{@$data['order_id']}}".</p>
          </td>
        </tr>
        <tr style="    width: 100%;    display: block;">
          <td style="    width: 100%;    display: block;">
            <p style="   padding: 4px 15px 5px 15px; margin: 0; font-size: 16px; font-weight: 500; ">Puja Link: <a href="{{@$data['puja_link']}}" style="font-size: 16px; font-weight: 400; color: #e8a173;">{{@$data['puja_link']}}</a></p>

            <hr style="margin: 15px 15px 5px; border:0; border-top:1px solid #e8e8e8 ; ">
          </td>
        </tr>
        <tr style="    width: 100%;    display: block;">
          <td style="    width: 100%;    display: block;">
            <p style="   padding:8px 15px 5px 15px; margin: 0; font-size: 16px; font-weight: 500;  "> Puja Note: <span style="font-size: 16px; font-weight: 400; color: #737373; font-weight: 400;"> {{@$data['puja_note']}}</span></p>
          </td>
        </tr>
        <tr style="    width: 100%;    display: block;">
          <td style="    width: 100%;    display: block;">
            <p style="   padding:20px 15px 2px 15px; margin: 0; font-style: italic;  font-weight: 600;  color: #434343;">Regards</p>
            <p style="   padding:0px 15px 5px 15px; margin-top: 0 ; color: #e8a173; font-size: 17px;">Astroaquila</p>
          </td>
        </tr>
      </tbody>
    </table>

  </body>
  </html>
