<!DOCTYPE html>
<html>

   @include('head')

   <body>
      

      <div class="title-center">
      <div class="title-left khmer-moul blue" >
         <img src="{{ asset('KNK-LOGO.png') }}" style="margin-left: 100px; max-width: 100px;" >
         <h2 style="margin-left: 70px;margin-top: -10px" > KNK HOMEAPPLIANCE</h2>
      </div>
         <h4 class="khmer-moul"style="margin-top:-40px">បញ្ជីរបាយការណ៍នៃការលក់</h4>
         <p style="text-align:center"> 
         កាលបរិច្ឆេទ៖ {{$from}} - {{$to}}</b>
         </p>
      </div>

      <div class="tbl-cnt" >

         <table style="width:100%; font-size:14px"  >
            <thead>
               <tr>
                  <th>ល.រ</th>
                  <th>Receipt Number</th>
                  <th>Customer</th>
                  <th>Product</th>
                  <th>Qty</th>
                  <!-- <th>Discount</th> -->
                  <th>Total Price</th>
                  <th>Date of Order</th>
                 
               </tr>
            </thead>
            <tbody id="tbl" >
            @php
               $i = 1;
               @endphp
               @foreach($data as $row)
               <tr>
                  <td>{{ $i++ }}</td>
                  <td>{{ $row->receipt_number ?? ''}}</td>
                  <td>{{ $row->customer->name ?? ''}} <br>{{ $row->customer->phone ?? ''}} </td>
                  <td>
                     @foreach($row->details as $item)
                     {{$item->product->name}} <br>
                     @endforeach
                  </td>
                  <td> 
                     @foreach($row->details as $item)
                     {{$item->qty}} <br>
                     @endforeach
                  </td>
                  <!-- <td>{{number_format($row->discount)}} %</td> -->
                  <td>{{number_format($row->total_price_khr)}}</td>
                  <td>{{ $row->created_at ?? '' }}</td>
                  
               </tr>
              @endforeach
            </tbody>
         </table>
      </div>

      <div>
      </div>
   </body>
</html>