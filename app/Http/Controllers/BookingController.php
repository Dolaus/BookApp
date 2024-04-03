<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CustomTabl;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;


class BookingController extends Controller
{
    public function allBookings()
    {
        $bookings = Booking::where('user_id', auth()->user()->id)->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function booking($id)
    {
        $user = User::findOrFail($id);
        $tables = $user->tables;

        $currentDateTime = new DateTime();
        $currentDateTime->modify('+3 hours');

        foreach ($tables as $table) {
            $bookings = $table->bookings->filter(function ($booking) use ($currentDateTime) {
                return $booking->start <= $currentDateTime && $booking->end >= $currentDateTime;
            });
            count($bookings) > 0 ? $table['is_available_for_now'] = 0 : $table['is_available_for_now'] = 1;
        }

        return view('visitor.booking.index', compact('user', 'tables'));
    }

    public function slots($id, Request $request)
    {
        $from = $request->get('from');
        $to = $request->get('to');
        $dateRange = ['from' => $from, 'to' => $to];
        $availableTime = ['from' => "08:00", 'to' => "20:00"];

        $res = $this->generateTimeSlots($dateRange, $availableTime, 30);


        $table = CustomTabl::find($id);

        foreach ($table->bookings as $item) {
            foreach ($res as &$subItem) {
                $dateTime1 = new \DateTime($subItem['start']);
                $dateTime2 = new \DateTime($item['start']);
                $dateTime3 = new \DateTime($subItem['end']);
                $dateTime4 = new \DateTime($item['end']);
                if ($dateTime1 == $dateTime2 && $dateTime3 == $dateTime4) {
                    $subItem['start'] = $item['start'];
                    $subItem['end'] = $item['end'];
                    $subItem['is_available'] = 0;
                }
            }
        }

        return $res;
    }


    public function generateTimeSlots($dateRange, $availableTime, $intervalMinutes)
    {
        $result = [];

        $startDate = new \DateTime($dateRange['from']);
        $endDate = new \DateTime($dateRange['to']);
        $startTime = new \DateTime($availableTime['from']);
        $endTime = new \DateTime($availableTime['to']);
        $interval = new \DateInterval("PT{$intervalMinutes}M");
        $currentDate = clone $startDate;
        while ($currentDate <= $endDate) {
            $dayOfWeek = strtolower($currentDate->format('l'));

            $currentTime = clone $startTime;

            while ($currentTime < $endTime) {
                $timeSlotStart = clone $currentDate;
                $timeSlotStart->setTime($currentTime->format('H'), $currentTime->format('i'));

                $timeSlotEnd = clone $timeSlotStart;
                $timeSlotEnd->add($interval);

                $excludeSlot = false;

                if (!$excludeSlot) {
                    $result[] = [
                        'start' => $timeSlotStart->format('Y-m-d\TH:i:s.u\Z'),
                        'end' => $timeSlotEnd->format('Y-m-d\TH:i:s.u\Z'),
                        'timestamp' => $timeSlotStart->getTimestamp(),
                        'is_available' => 1
                    ];
                }

                $currentTime->add($interval);
            }


            $currentDate->add(new \DateInterval('P1D'));
        }

        return $result;
    }

    public function makeBook(Request $request)
    {
        $data = $request->all();
        $start = $data['start'];
        $end = $data['end'];

//        $startDateTime = new DateTime($start);
//        $endDateTime = new DateTime($end);
//
//        $startDateTime->modify('+1 day');
//        $endDateTime->modify('+1 day');
//
//        $start = $startDateTime->format('Y-m-d H:i:s');
//        $end = $endDateTime->format('Y-m-d H:i:s');
        $id = $data['id'];

        return view('visitor.booking.makeBook', compact('start', 'end', 'id'));
    }

    public function saveBook(Request $request)
    {
        $data = $request->all();
        $table = CustomTabl::findOrFail($data['id']);
        $booking = Booking::create([
            'start' => $data['start'],
            'end' => $data['end'],
            'is_available' => 1,
            'table_id' => $data['id'],
            'user_id' => $table['user_id'],
        ]);
        return view('visitor.booking.success');

    }

}
