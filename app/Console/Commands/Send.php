<?php

namespace App\Console\Commands;

use App\Email_list;
use App\Problem;
use Illuminate\Console\Command;
use Psr\Log;

use Illuminate\Support\Facades\Mail;

class Send extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Message';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dat = date("Y-m-d", time() - 86400);
        $d = date("2020-11-29 00:00:00");


        $model = Problem::where('email_status', null)
            ->where('current_stage_id',2)
            ->where('created_at', '<', $dat)
            ->where('created_at', '>', $d)
            ->get();

        foreach ($model as $key => $val) {

            $email_model = explode(';', $val->vehicleModel->responsible_email);
            $email_dep = explode(';', $val->department->email);
            $email_list = Email_list::all();
            $list = [];

            foreach ($email_list as $keyy => $vall) {
                $list[] = $vall->email;
            }
            $email = array_merge($email_dep, $email_model, $list);
            Mail::send('emails.action_status', [
                'vin' => $val->vin,
                'department' => $val->department->name,
                'model' => $val->vehicleModel->name,
                'desc' => $val->description,
                'date' => $val->created_at
            ],
                function ($message) use ($email) {
                    $message->subject('Status bo`yicha natija bo`lmadi (test xabar))')
                        ->to($email);
                });
            $val->email_status = 1;
            $val->save();
        }

        \Log::info('Liverpoool Chempioonnnn!' . time());
    }
}
