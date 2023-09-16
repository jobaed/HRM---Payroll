<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use App\Models\UserDetails;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {
    /**
     * Display a listing of the resource.
     *
     */

    // For Frontend Pages
    public function loginPage(): View {
        return view( 'Frontend.pages.auth.login' );
    }
    public function regiPage(): View {
        return view( 'Frontend.pages.auth.regi' );
    }
    public function otpPage(): View {
        return view( 'Frontend.pages.auth.otp' );
    }
    public function verifyotpPage(): View {
        return view( 'Frontend.pages.auth.verifyOTP' );
    }
    public function resetPassPage(): View {
        return view( 'Frontend.pages.auth.reset-pass' );
    }

    // Dashboard Pages

    public function dashboardPage(): View {
        return view( 'Frontend.pages.dashboard.dashboard' );
    }
    public function ProfilePage(): View {
        return view( 'Frontend.pages.dashboard.userProfile' );
    }

    // For API Call
    public function storeAPIData( Request $request ) {

        $validator = Validator::make( $request->all(), [
            'firstName' => 'required|string|max:150',
            'lastName'  => 'required|string|max:150',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6',
            'mobile'    => 'required|max:15',
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Invallid Input',
            ] );
        }

        try {

            $user_id = $request->header( 'id' );

            if ( $request->file( 'profile' ) ) {

                DB::beginTransaction();

                try {

                    if ( $request->input( 'about_me' ) == '' ) {
                        $aboutMe = "Your About Me";
                    } else {
                        $aboutMe = $request->input( 'about_me' );
                    }
                    if ( $request->input( 'selary' ) == '' ) {
                        $Employeeselary = "Neiogatable";
                    } else {
                        $aboutMe = $request->input( 'selary' );
                    }
                    if ( $request->input( 'role' ) == '' ) {
                        $role = "user";
                    } else {
                        $role = $request->input( 'role' );
                    }

                    // Prepare File Name & Path
                    $img = $request->file( 'profile' );

                    $t = time();
                    $file_name = $img->getClientOriginalName();
                    $img_name = "{$user_id}-{$t}-{$file_name}";
                    $img_url = "profile/{$img_name}";

                    // Upload File
                    $img->move( public_path( 'profile' ), $img_name );

                    // Insert User;
                    $user_data = new User();
                    $user_data->firstName = $request->input( 'firstName' );
                    $user_data->lastName = $request->input( 'lastName' );
                    $user_data->mobile = $request->input( 'mobile' );
                    $user_data->email = $request->input( 'email' );
                    $user_data->password = $request->input( 'password' );
                    $user_data->role = $role;

                    $user_data->save();

                    $employeeInsert_id = $user_data->id;

                    // Insert User Details
                    UserDetails::create( [
                        'user_id'  => $employeeInsert_id,
                        'profile'  => $img_url,
                        'about_me' => $request->input( 'about_me' ),
                        'selary'   => $request->input( 'selary' ),
                    ] );

                    DB::commit();

                    return response()->json( [
                        'status'  => 'success',
                        'message' => 'Employee Create',
                    ], 200 );

                } catch ( Exception $e ) {
                    DB::rollBack();
                    return $e;
                }
            } else {
                DB::beginTransaction();

                if ( $request->input( 'about_me' ) == '' ) {
                    $aboutMe = "Your About Me";
                } else {
                    $aboutMe = $request->input( 'about_me' );
                }
                if ( $request->input( 'selary' ) == '' ) {
                    $Employeeselary = "Neiogatable";
                } else {
                    $aboutMe = $request->input( 'selary' );
                }
                if ( $request->input( 'role' ) == '' ) {
                    $role = "user";
                } else {
                    $role = $request->input( 'role' );
                }

                try {

                    // Insert User;
                    $user_data = new User();
                    $user_data->firstName = $request->input( 'firstName' );
                    $user_data->lastName = $request->input( 'lastName' );
                    $user_data->mobile = $request->input( 'mobile' );
                    $user_data->email = $request->input( 'email' );
                    $user_data->password = $request->input( 'password' );
                    $user_data->role = $role;

                    $user_data->save();
                    $employeeInsert_id = $user_data->id;

                    UserDetails::create( [
                        'about_me' => $aboutMe,
                        'user_id'  => $employeeInsert_id,
                        'profile'  => "noImage",
                        'selary'   => $Employeeselary,
                    ] );

                    DB::commit();
                    return response()->json( [
                        'status'  => 'success',
                        'message' => 'User Update Successfull',
                    ], 200 );

                } catch ( Exception $e ) {
                    DB::rollBack();
                    return $e;
                }
            }

        } catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'failed',
                'message' => $e,
            ], 200 );
        }

    }

    public function userLogin( Request $request ) {

        $validator = Validator::make( $request->all(), [
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Invallid Input',
                'code'    => '403',
            ], 200 );
        }

        $count = User::where( $request->all() )->select( 'id' )->first();

        if ( $count !== null ) {

            $token = JWTToken::CreateToken( $request->email, $count->id );
            return response()->json( [
                'status'  => 'success',
                'message' => 'User Login Successfull',
            ], 200 )->cookie( 'token', $token, 60 * 60 * 24 );

        } else {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Unauthorized',
                'code'    => 401,
            ], 200 );
        }

    }

    public function SendOTPCode( Request $request ) {

        $validator = Validator::make( $request->all(), [
            'email' => 'required|email',
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Invallid Email',
                'code'    => '401',
            ], 200 );
        }

        $email = $request->input( 'email' );
        $otp = rand( 100000, 999999 );

        $count = User::where( 'email', '=', $email )->count();
        if ( $count == 1 ) {
            // Send Email
            Mail::to( $email )->send( new OTPMail( $otp ) );

            // Otp Update Database
            User::where( 'email', '=', $email )->update( ['otp' => $otp] );

            return response()->json( [
                'status'  => 'success',
                'message' => 'Your Password Reset OTP Has been send',

            ], 200 );

        } else {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Unauthorized',
                'code'    => '403',
            ], 200 );
        }
    }

    public function VerifiedOTP( Request $request ) {
        $validator = Validator::make( $request->all(), [
            'otp' => 'required|min:6|max:6',
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Invallid Input',
                'code'    => '403',
            ], 200 );
        }

        $email = $request->input( 'email' );
        $otp = $request->input( 'otp' );

        $count = User::where( 'email', '=', $email )
            ->where( 'otp', '=', $otp )->select( 'id' )->first();

        if ( $count !== null ) {

            // Update Otp
            User::where( 'email', '=', $email )->update( ['otp' => '0'] );

            // Create Reset Token
            $token = JWTToken::CreateTokenForSetPassword( $request->email, $count->id );
            return response()->json( [
                'status'  => 'success',
                'message' => 'OTP Varification Successfull',
            ], 200 )->cookie( 'token', $token, 60 * 60 * 24 );

        } else {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Not Match',
                'code'    => '404',
            ], 200 );
        }

    }

    public function ResetPass( Request $request ) {

        $validator = Validator::make( $request->all(), [
            'password' => 'required|min:6',
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Invallid Input',
                'code'    => '403',
            ] );
        }

        try {
            $token = $request->cookie( 'token' );
            $password = $request->input( 'password' );

            $tokenInfo = JWTToken::VerifyToken( $token );
            $email = $tokenInfo->userEmail;
            //  return $email;

            User::where( 'email', '=', $email )->update( ['password' => $password] );

            return response()->json( [
                'status'  => 'success',
                'message' => 'Request Success',
            ], 200 )->cookie( 'token', '', -1 );

        } catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Something Went Wrong',
            ] );
        }

    }

    public function logOut() {
        return redirect( '/login' )->cookie( 'token', '', -1 );
    }

    // Get Profile Data
    function UserProfile( Request $request ) {
        $email = $request->header( 'email' );

        $user = User::where( 'email', '=', $email )->first();

        if ( $user !== null ) {
            return response()->json( [
                'status'  => 'success',
                'message' => 'Request Successfull',
                'data'    => $user,
            ] );
        } else {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'User Not Found',
                'code'    => '404',
            ] );
        }
    }

    // User Profile update
    function userUdate( Request $request ) {
        $validator = Validator::make( $request->all(), [
            'firstName' => 'required|string|max:150',
            'lastName'  => 'required|string|max:150',
            'password'  => 'required|min:6',
            'mobile'    => 'required|max:15',
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Invallid Input',
                'code'    => '403',
            ] );
        }

        $email = $request->header( 'email' );

        // // return $request->all();

        try {

            if ( $request->input( 'id' ) ) {
                $user_id = $request->input( 'id' );
            } else {
                $user_id = $request->header( 'id' );
            }

            if ( $request->file( 'profile' ) ) {

                DB::beginTransaction();

                try {
                    // Prepare File Name & Path
                    $img = $request->file( 'profile' );

                    $t = time();
                    $file_name = $img->getClientOriginalName();
                    $img_name = "{$user_id}-{$t}-{$file_name}";
                    $img_url = "profile/{$img_name}";

                    // Upload File
                    $img->move( public_path( 'profile' ), $img_name );

                    //  Delete Old Image
                    $old_image = $request->input( 'old_img' );
                    if ( File::exists( $old_image ) ) {
                        File::delete( $old_image );
                    }

                    User::where( 'id', '=', $user_id )->update( [
                        'firstName' => $request->input( 'firstName' ),
                        'lastName'  => $request->input( 'lastName' ),
                        'email'  => $request->input( 'email' ),
                        'mobile'    => $request->input( 'mobile' ),
                        'password'  => $request->input( 'password' ),
                        'role'      => $request->input( 'role' ),
                    ] );

                    // $user_id = $userData->id;

                    UserDetails::where( 'user_id', '=', $user_id )->update( [
                        'profile'  => $img_url,
                        'about_me' => $request->input( 'about_me' ),
                        'selary'   => $request->input( 'selary' ),
                    ] );

                    DB::commit();

                    return response()->json( [
                        'status'  => 'success',
                        'message' => 'User Update Successfull',
                    ], 200 );

                } catch ( Exception $e ) {
                    DB::rollBack();
                    return $e;
                }
            } else {
                DB::beginTransaction();

                try {
                    User::where( 'id', '=', $user_id )->update( [
                        'firstName' => $request->input( 'firstName' ),
                        'lastName'  => $request->input( 'lastName' ),
                        'mobile'    => $request->input( 'mobile' ),
                        'email'  => $request->input( 'email' ),
                        'password'  => $request->input( 'password' ),
                        'role'      => $request->input( 'role' ),
                    ] );

                    // $user_id = $userData->id;

                    UserDetails::where( 'user_id', '=', $user_id )->update( [
                        'about_me' => $request->input( 'about_me' ),
                        'selary'   => $request->input( 'selary' ),
                    ] );

                    DB::commit();
                    return response()->json( [
                        'status'  => 'success',
                        'message' => 'User Update Successfull',
                    ], 200 );

                } catch ( Exception $e ) {
                    DB::rollBack();
                    return $e;
                }
            }

        } catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'failed',
                'message' => $e,
            ], 200 );
        }
    }

    // Get Profile Data
    function UserFullProfile( Request $request ) {
        $id = 0;

        if ( $request->input( 'id' ) ) {
            $id = $request->input( 'id' );
        } else {
            $id = $request->header( 'id' );
        }

        $user = User::with( 'UserDetail' )->where( 'id', '=', $id )->first();

        if ( $user !== null ) {
            return response()->json( [
                'status'  => 'success',
                'message' => 'Request Successfull',
                'data'    => $user,
            ] );
        } else {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'User Not Found',
                'code'    => '404',
            ] );
        }
    }

    // User RegiFrom for Admin
    function userPageForAdmin() {
        return view( 'Frontend.pages.dashboard.employee' );
    }

    // Employee List
    public function employeeList( Request $request ) {
        $user_email = $request->header( 'email' );
        $data = User::with( 'UserDetail' )->where( 'email', '!=', $user_email )->get();
        if ( $data->count() == 0 ) {
            return response()->json( [
                'status'  => 'error',
                'message' => 'Data Not Found',
                'data'    => null,
            ] );
        } else {
            return response()->json( [
                'status'  => 'success',
                'message' => 'Request Successfull',
                'data'    => $data,
            ] );
        }
    }
    // Get Single Employee List
    public function singleEmployee( Request $request ) {
        $id = $request->input( 'id' );
        // $employeeId =
        $data = User::with( 'UserDetail' )->where( 'id', '=', $id )->first();

        if ( $data ) {
            return response()->json( [
                'status'  => 'success',
                'message' => 'Request Successfull',
                'data'    => $data,
            ] );

        } else {
            return response()->json( [
                'status'  => 'error',
                'message' => 'Employee Not Found',
                'data'    => null,
            ] );
        }
    }

    // Delete Employee
    public function deleteEmployee( Request $request ) {
        $id = $request->input( 'id' );

        $employee = User::where( 'id', '=', $id )->first();

        if ( $employee->count() == 0 ) {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Data Not Found',
                'code'    => '200',
            ] );
        } else {

            try {
                DB::beginTransaction();
                $employee_detaails = UserDetails::where( 'user_id', '=', $id )->first();
                $employee_detaails->delete();
                $employee->delete();

                DB::commit();

                return response()->json( [
                    'status'  => 'success',
                    'message' => 'Data has been Deleted',
                    'code'    => '200',
                ] );

            } catch ( Exception $e ) {
                DB::rollBack();
                return response()->json( [
                    'status'  => 'faild',
                    'message' => $e,
                    'code'    => '200',
                ] );
            }

        }
    }





}
