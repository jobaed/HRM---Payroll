<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendanceRecordController extends Controller {

    public function InAttendence( Request $request ) {

        $validator = Validator::make( $request->all(), [

            'clock_in' => 'required|string|max:150',
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Invallid Input',
                'error'   => $validator->errors(),
            ] );
        } else {

            $user_id = $request->header( 'id' );

            try {

                $time = date( 'h:i:s' );

                $currentDate = Carbon::now()->toDateString();

                $currentDateTime = Carbon::now();
                $startTime = Carbon::now()->setTime( 10, 0, 0 ); // 10:00 AM
                $endTime = Carbon::now()->setTime( 02, 0, 0 ); // 7:00 PM

                if ( $currentDateTime ) {
                    $in = AttendanceRecord::whereDate( 'created_at', $currentDate )->where( 'user_id', '=', $user_id )->first();
                    if ( $in->count() > 0 ) {
                        $in->update( [
                            'clock_in' => $time,
                        ] );
                        return response()->json( [
                            'status'  => 'success',
                            'message' => 'Out Successfully',
                            'data'    => $in,
                        ] );

                    }
                } else {
                    return response()->json( [
                        'status'  => 'error',
                        'message' => 'It\'s Not Out Time',
                        'data'    => '',
                    ] );
                }

            } catch ( Exception $e ) {

                return $e;
            }

        }
    }

    public function OutAttendence( Request $request ) {

        $validator = Validator::make( $request->all(), [

            'clock_out' => 'required|string|max:150',

        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Invallid Input',
                'error'   => $validator->errors(),
            ] );
        } else {

            $user_id = $request->header( 'id' );

            try {

                $time = date( 'h:i:s' );

                $currentDate = Carbon::now()->toDateString();

                $currentDateTime = Carbon::now();
                $startTime = Carbon::now()->setTime( 10, 0, 0 ); // 10:00 AM
                $endTime = Carbon::now()->setTime( 19, 0, 0 ); // 7:00 PM

                if ( $currentDateTime ) {
                    $in = AttendanceRecord::whereDate( 'created_at', $currentDate )->where( 'user_id', '=', $user_id )->first();
                    if ( $in->count() > 0 ) {
                        $in->update( [
                            'clock_out' => $time,
                        ] );

                        return response()->json( [
                            'status'  => 'success',
                            'message' => 'Out Successfully',
                            'data'    => $in,
                        ] );

                    }
                } else {
                    return response()->json( [
                        'status'  => 'error',
                        'message' => 'It\'s Not Out Time',
                        'data'    => '',
                    ] );
                }

            } catch ( Exception $e ) {

                return $e;
            }

        }
    }

    public function getTodayAttendence( Request $request ) {
        $user_id = $request->header( 'id' );

        $currentDate = Carbon::now()->toDateString();
        $attendence = AttendanceRecord::whereDate( 'created_at', $currentDate )->where( 'user_id', '=', $user_id )->first();
        // return $attendence;

        if ( $attendence ) {

            if ( $attendence->clock_in != null && $attendence->clock_out != null ) {

                $attendence = AttendanceRecord::whereDate( 'created_at', $currentDate )->where( 'user_id', '=', $user_id )->first();
                $time1 = Carbon::createFromFormat( 'H:i:s', $attendence->clock_in );
                $time2 = Carbon::createFromFormat( 'H:i:s', $attendence->clock_out );

                // Subtract $time2 from $time1
                $timeDifference = $time1->diff( $time2 );
                $hours = $timeDifference->h;
                $minutes = $timeDifference->i;
                $seconds = $timeDifference->s;

                $toDayAttendence = "Your Today Duty Time : ( {$hours} : {$minutes} : {$seconds} )";
                return response()->json( [
                    'status'   => 'success',
                    'message'  => 'Data Get',
                    'data'     => $attendence,
                    "dutyTime" => $toDayAttendence,
                ] );

            } else {
                return response()->json( [
                    'status'  => 'success',
                    'message' => 'Data Get',
                    'data'    => $attendence,
                    "dutyTime" => null,
                ] );
            }

        } else {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Data Not Found',
                'data'    => null,
            ] );
        }
    }

    public function attendencePage() {
        return view( 'Frontend.pages.dashboard.attendence' );
    }

    public function myAttendence( Request $request ) {

        $user_id = $request->header( 'id' );

        $attendence = AttendanceRecord::where( "user_id", "=", $user_id )->get();

        // return $attendence;
        return response()->json( [
            'status'  => 'success',
            'message' => 'Data Get Successfull',
            'data'    => $attendence,
        ] );
    }

}
