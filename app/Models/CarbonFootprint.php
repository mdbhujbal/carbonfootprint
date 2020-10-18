<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarbonFootprint extends Model
{
    use HasFactory;
	
	protected $fillable = [
        'activity',
        'activity_type',
        'fuel_type',
        'mode',
        'country',
        'carbon_footprint',
		'is_active'	
    ];
	
	/**
     * Function returns the carbon footprint from either database or from api
     *
     * @param  string  $activity
     * @param  string  $activity_type
     * @param  string  $country
     * @param  string  $fuel_type
     * @param  string  $mode
     * @return array
     */
	public static function getCarbonFootprint($activity, $activity_type, $country, $fuel_type, $mode)
    {
		$response = array();
		
		//Check if database has an active record for the given inputs
        $existing_record = CarbonFootprint::where([
			'activity' => $activity,
            'activity_type' => $activity_type,
            'fuel_type' => $fuel_type,
            'mode' => $mode,
            'country' => $country,
			'is_active' => '1'
		])->get();
		
		//If we found an active record in the databse, check if it is not older than 1 day. If older than 1 day, then invalidate the record and get fresh footprint from the api
		//Note: we can escape this check if we run scheduler/cron job daily once to deactivate all the rows which are older than 1 day.
		if(count($existing_record))
		{
			$datetime1 = strtotime($existing_record[0]->created_at); // convert to timestamps
			$datetime2 = time(); // convert to timestamps
			$difference = (int)(($datetime2 - $datetime1) / 86400); // will give the difference in days , 86400 is the timestamp difference of a day
			
			if($difference >= 1) //If older than 1 day, deactivate the record from database
			{
				$row = CarbonFootprint::find($existing_record[0]->id);
				$row->is_active =  '0';
				$row->save();
			}
			else //return the footprint stored in the database
			{
				$response['carbon_footprint'] = $existing_record[0]->carbon_footprint;
			}		
		}
		
		//If database has no active record available, then get fresh footprint from the api
		if(!isset($response['carbon_footprint']))
		{	
			$api_response = file_get_contents('https://api.triptocarbon.xyz/v1/footprint?activity='.urlencode($activity).'&activityType='.urlencode($activity_type).'&country='.urlencode($country).'&fuelType='.urlencode($fuel_type).'&mode='.urlencode($mode));
			
			if($api_response)
			{	
				if(!isset($api_response['errorMessage']))
				{	
					$api_response = json_decode($api_response, TRUE);
					
					$response['carbon_footprint'] = $api_response['carbonFootprint'];
					
					//Store the record in databse
					$carbonfootprint = new CarbonFootprint([
						'activity' => $activity,
						'activity_type' => $activity_type,
						'fuel_type' => $fuel_type,
						'mode' => $mode,
						'country' => $country,
						'carbon_footprint' => $response['carbon_footprint']
					]);
					$carbonfootprint->save();
				}
				else
				{
					$response['error'] = $api_response['errorMessage'];
				}		
			}
		}
		
		return $response;
    }
}
