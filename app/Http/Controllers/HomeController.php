<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use Hash;
use Auth;
use Mail;
use App\Bill;
use App\Categories;
use App\Products;
use App\PageUrl;
use App\Helpers\Helper;

class HomeController extends Controller
{
    function postDeleteProduct(Request $req){
        // print_r($req->all());die;
        $id = $req->id;
        $product = Products::find($id);
        if($product){
            $product->deleted = 1; //da xoa
            $product->save();
            return response(['result'=>true]);            
        }
        else{
            return response(['result'=>false]);
        }
    }

    function getAddProduct(){
        return view('pages.add-product');
    }

    function postAddProduct(Request $req){
        $helper = new Helper;
        $url = new PageUrl;
        $url->url = $helper->changeTitle($req->name);
        $url->save();
        $product = new Products;
        $product->name = $req->name;
        $product->price = $req->price;
        $product->promotion_price = $req->promotion_price;
        $product->detail = $req->detail;
        $product->id_type = $req->type;
        $product->id_url = $url->id; //line 39
        $product->promotion = $req->promotion;
        $product->update_at = date('Y-m-d H:i:s',time());
        if(isset($req->status)){
            $product->status = $req->status;
        }
        $product->new = isset($req->new) ? $req->new : 0;
         if($req->hasFile('image')){
            $image = $req->file('image');
            if($image->getSize() > 2*1024*1024){
                return redirect()->back()->with('error','File quá lớn');
            }
            $arrExt = ['png','jpg','gif','jpeg'];
            $ext = $image->getClientOriginalExtension();
            if(!in_array($ext,$arrExt)){
                return redirect()->back()->with('error','File không cho phép');
            }
            $newName = date('Y-m-d-H-i-s-',time()).$image->getClientOriginalName();
            $image->move("products-images/",$newName);
            //save new name
            $product->image = $newName;
        }
        else{
            return redirect()->back()->with('error','Vui lòng chọn hình');
        }
        $product->save();
        return redirect()->route('list-product',$product->id_type)->with('success','Thêm thành công');
     }

    function getUpdateProduct($id){
        $product = Products::find($id);
        if($product){
            return view('pages.update-product',compact('product'));
        }
        else{
            return redirect()->back()->with('error','Không tìm thấy sản phẩm');
        }
    }

    function postUpdateProduct(Request $req){
        $product = Products::find($req->id);
        if(!$product){
            return redirect()->back()->with('error','Không tìm thấy sản phẩm');
        }
         //update product
         $product->name = $req->name;
         $product->price = $req->price;
         $product->promotion_price = $req->promotion_price;
         $product->detail = $req->detail;
         $product->id_type = $req->type;
         $product->promotion = $req->promotion;
         $product->update_at = date('Y-m-d H:i:s',time());
         if(isset($req->status)){
             $product->status = $req->status;
         }
         $product->new = isset($req->new) ? $req->new : $product->new;
          if($req->hasFile('image')){
             $image = $req->file('image');
             if($image->getSize() > 2*1024*1024){
                 return redirect()->back()->with('error','File quá lớn');
             }
             $arrExt = ['png','jpg','gif','jpeg'];
             $ext = $image->getClientOriginalExtension();
             if(!in_array($ext,$arrExt)){
                 return redirect()->back()->with('error','File không cho phép');
             }
             $newName = date('Y-m-d-H-i-s-',time()).$image->getClientOriginalName();
             $image->move("products-images/",$newName);
             if(file_exists("products-images/".$product->image)){
                 unlink("products-images/".$product->image);
             }
             //save new name
             $product->image = $newName;
         }
         $product->save();
         //update url
         //find page_url
         $url = PageUrl::find($product->id_url);
         if($url){
             $helper = new Helper;
             $url->url = $helper->changeTitle($product->name);
             $url->save();
         }
         return redirect()->route('list-product',$product->id_type)->with('success','Cập nhật thành công');
 
    }

    function listProduct($idType){
        $type = Categories::where('id',$idType)->first();
        if($type){
            $listProduct = Products::where([
                ['id_type','=',$idType],
                ['deleted','=',0]
            ])->paginate(5);
            // dd($listProduct);
            return view('pages.list-product',compact('listProduct','type'));
        }
        else{
            return redirect()->back()->with('error','Không tìm thấy loại sản phẩm');
        }
        
    }

    function updateStatusBill(Request $req){
        $bill = Bill::where('id','=',$req->id_bill)
                ->where(function($q){
                    $q->where('status','=',0);
                    $q->orWhere('status','=',1);
                })->first();
        if($bill){
            $bill->status = $req->status;
            $bill->save();
            echo 'ok';
        }
        else{
            echo 'notok';
        }
        return;
    }

    function successStatusBill(Request $req){
        $bill = Bill::where([
                ['id','=',$req->id_bill],
                ['status','=',1]
        ])->first();
        $data=[];
        if($bill){
            $bill->status = $req->status;
            $bill->save();
            echo 'ok';
        }
        else{
            echo 'notok';
        }
        return;
    }

    function index(){
        return redirect()->route('listbill',['status'=>0]);
    }

     function listBill(Request $req){
        $status = $req->status;
        $bills = Bill::with('customer','product','billDetail')
                ->where('status','=',$status)
                ->paginate(5);
                // var_dump($bills);
        return view('pages.index',compact('bills','status'));
    }

    function getLogin(){
        return view('pages.login');
    }
    function postLogin(Request $req){
        //validator
        $data = [
            'email'=>$req->email,
            'password'=>$req->password,
        ];
        if(Auth::attempt($data)){
            // dd(Auth::user());
            return redirect()->route('home');
        }
        else{
            return redirect()->back()->with('error','Email hoặc password không hợp lệ');
        }
    }

    function getRegister(){
        return view('pages.register');
    }

    function postRegister(Request $req){
        $validator = Validator::make($req->all(), [
            'username'=>'required|min:6|unique:users,username',
            'fullname'=>'required',
            'birthdate'=>'required',
            'gender'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6',
            'confirmation_password'=>'required|same:password',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput($req->all());
        }
        // dd($req->all());
        $user = new User;
        $user->username = $req->username;
        $user->fullname = $req->fullname;
        $user->birthdate = date('Y-m-d', strtotime($req->birthdate));
        $user->gender = $req->gender;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->save();
        return redirect()->route('login')->with('success','You can login now');
    }

    function logout(){
        Auth::logout();
        return redirect()->route('login');
    }

    
}
