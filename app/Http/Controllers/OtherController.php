<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Contact;
use Illuminate\Support\Facades\Redirect;
use Validator, Response, DB;
use Excel;
use App\Model\Crm;
use App\Model\UserProperty;
use App\Model\Search;
use Illuminate\Support\Facades\Storage;
use App\Imports\ImportUsers;
class OtherController extends Controller
{
    public function contact()
    {
    	$user=Contact::orderBy('id','desc')->get();
    	return view('contact.list',compact('user')); 
    }

    public function faq($value='')
    {
    	$data=DB::table('cms')->select('faq')->first();
    	return view('cms.faq',compact('data')); 
    }

    public function faqDb(Request $request)
    {
    	DB::table('cms')->update(['faq'=>$request->get('description')]);
    	 return Redirect::back()->withSuccess('Successfully Updated!!');
    }

    public function about($value='')
    {
    	$data=DB::table('cms')->select('about')->first();
    	return view('cms.about',compact('data')); 
    }    

    public function aboutDb(Request $request)
    {
    	DB::table('cms')->update(['about'=>$request->get('description')]);
    	 return Redirect::back()->withSuccess('Successfully Updated!!');
    }

    public function privacy($value='')
    {
    	$data=DB::table('cms')->select('privacy')->first();
    	return view('cms.privacy',compact('data')); 
    }    

    public function privacyDb(Request $request)
    {
    	DB::table('cms')->update(['privacy'=>$request->get('description')]);
    	 return Redirect::back()->withSuccess('Successfully Updated!!');
    }

    public function terms($value='')
    {
    	$data=DB::table('cms')->select('terms')->first();
    	return view('cms.terms',compact('data')); 
    }    

    public function termsDb(Request $request)
    {
    	DB::table('cms')->update(['terms'=>$request->get('description')]);
    	 return Redirect::back()->withSuccess('Successfully Updated!!');
    }

    public function excel(Request $request)
    {
        // $upld_file = $request->file('csv')->store('csvs');

        $uploadedFile = $request->file('csv');
        $filename = time().$uploadedFile->getClientOriginalName();
          Storage::putFileAs(
            'csvs',
            $uploadedFile,
            $filename
          );
        $path=storage_path('app/csvs/'.$filename);
        $data = \Excel::toArray(new ImportUsers,$path);
        foreach ($data[0] as $key => $value) {
            if($key!=0){
                $check=array(
                    'APN_UNFORMATTED'=>$value[54]
                );
                $val=array(
                    'property_id'=>uniqid().time(),
                    'OWNER_1_FULL_NAME'=>$value[0],   
                    'OWNER_1_FIRST_NAME_&_MI'=>$value[1],
                    'OWNER_1_FIRST_NAME'=>$value[2],
                    'OWNER_1_LAST_NAME'=>$value[3],
                    'OWNER_1_TYPE'=>$value[4],
                    'OWNER_1_PROPERTIES_OWNED'=>$value[5],    
                    'OWNER_2_FULL_NAME'=>$value[6],   
                    'OWNER_2_FIRST_NAME_&_MI'=>$value[7], 
                    'OWNER_2_FIRST_NAME'=>$value[8],  
                    'OWNER_2_LAST_NAME'=>$value[9],   
                    'OWNER_2_TYPE'=>$value[10],    
                    'OWNER_2_PROPERTIES_OWNED'=>$value[11],    
                    'OWNER_3_FULL_NAME'=>$value[12],   
                    'OWNER_4_FULL_NAME'=>$value[13],   
                    'OWNER_MAILING_NAME'=>$value[14],  
                    'OWNERS_ALL'=>$value[15],  
                    'OWNER_RELATIONSHIP_TYPE'=>$value[16], 
                    'OWNER_RIGHTS_VESTING_CODE'=>$value[17],   
                    'OWNER_ETAL_VESTING_CODE'=>$value[18], 
                    'OWNER_STATUS'=>$value[19],    
                    'DO_NOT_MAIL'=>$value[20], 
                    'SITUS_DIRECTION'=>$value[21], 
                    'SITUS_HOUSE_NUMBER'=>$value[22],  
                    'SITUS_HOUSE_NUMBER_2'=>$value[23],    
                    'SITUS_POST_DIRECTION'=>$value[24],    
                    'SITUS_STREET_NAME'=>$value[25],   
                    'SITUS_STREET_NAME_SUFFIX'=>$value[26],    
                    'SITUS_UNIT_NUMBER'=>$value[27],   
                    'SITUS_CITY'=>$value[28],  
                    'ALTERNATE_SITUS_CITY'=>$value[29],    
                    'SITUS_STATE'=>$value[30], 
                    'SITUS_ZIP_CODE'=>$value[31],  
                    'SITUS_ZIP_4'=>$value[32], 
                    'COUNTY'=>$value[33],  
                    'SITUS_CARRIER_ROUTE'=>$value[34], 
                    'SITUS_STREET_ADDRESS'=>$value[35],    
                    'SITUS_FULL_ADDRESS'=>$value[36],  
                    'MAIL_DIRECTION'=>$value[37],  
                    'MAIL_HOUSE_NUMBER'=>$value[38],   
                    'MAIL_HOUSE_NUMBER_2'=>$value[39], 
                    'MAIL_POST_DIRECTION'=>$value[40], 
                    'MAIL_STREET_NAME'=>$value[41],    
                    'MAIL_STREET_NAME_SUFFIX'=>$value[42], 
                    'MAIL_UNIT_NUMBER'=>$value[43],
                    'MAIL_CITY'=>$value[44],   
                    'ALTERNATE_MAILING_CITY'=>$value[45],  
                    'MAIL_STATE'=>$value[46],  
                    'MAIL_ZIP'=>$value[47],    
                    'MAIL_CARRIER_ROUTE'=>$value[48],  
                    'MAILING_STREET_ADDRESS'=>$value[49],  
                    'MAILING_FULL_ADDRESS'=>$value[50],    
                    'MAILING_COUNTRY'=>$value[51], 
                    'LEGAL_DESCRIPTION'=>$value[52],   
                    'APN_FORMATTED'=>$value[53],   
                    'APN_UNFORMATTED'=>$value[54], 
                    'ALTERNATE_APN'=>$value[55],   
                    'FIPSCODE'=>$value[56],    
                    'MUNICIPALITY_TOWNSHIP'=>$value[57],
                    'CENSUS_TRACT'=>$value[58],
                    'CENSUS_BLOCK'=>$value[59],
                    'OPPORTUNITY_ZONE'=>$value[60],
                    'TOWNSHIP'=>$value[61],
                    'RANGES'=>$value[62],
                    'SECTION'=>$value[63],
                    'QUARTER'=>$value[64],
                    'LATITUDE'=>$value[65],
                    'LONGITUDE'=>$value[66],
                    'SUBDIVISION'=>$value[67], 
                    'TRACT'=>$value[68],   
                    'APPRAISAL_DISTRICT'=>$value[69],  
                    'MACRO_NEIGHBORHOOD'=>$value[70],  
                    'NEIGHBORHOOD'=>$value[71],    
                    'SUB_NEIGHBORHOOD'=>$value[72],    
                    'RESIDENTIAL_NEIGHBORHOOD'=>$value[73],    
                    'MAP_REF1'=>$value[74],
                    'MAP_REF2'=>$value[75],
                    'LEGAL_BOOK'=>$value[76],
                    'LEGAL_PAGE'=>$value[77],
                    'LEGAL_LOT'=>$value[78],
                    'LEGAL_BLOCK'=>$value[79],
                    'GROSS_AREA'=>$value[80],
                    'LIVING_AREA'=>$value[81],
                    'MAIN_AREA'=>$value[82],
                    'GROUND_FLOOR_AREA'=>$value[83],   
                    'ADJUSTED_AREA'=>$value[84],   
                    'ABOVE_GRADE_SQFT'=>$value[85],    
                    'ADDITION_AREA'=>$value[86],   
                    'YEAR_BUILT'=>$value[87],  
                    'YEAR_BUILT_EFFECTIVE'=>$value[88],    
                    'NUMBER_OF_ROOMS'=>$value[89], 
                    'NUMBER_OF_BEDROOMS'=>$value[90],  
                    'NUMBER_OF_BATHS'=>$value[91], 
                    'BATHS_RESTROOMS_FULL'=>$value[92],    
                    'BATHS_RESTROOMS_HALF'=>$value[93],    
                    'FIXTURES_NUMBER'=>$value[94], 
                    'OTHER_ROOMS'=>$value[95],
                    'DINING_ROOMS'=>$value[96],   
                    'FAMILY_ROOMS'=>$value[97],    
                    'STORIES_NO'=>$value[98],  
                    'STORIES_DESCRIPTION'=>$value[99], 
                    'POOL'=>$value[100],    
                    'POOL_AREA'=>$value[101],   
                    'FIREPLACE_INDICATOR'=>$value[102], 
                    'FIREPLACE_NUMBER'=>$value[103],    
                    'PARKING_TYPE'=>$value[104],    
                    'PARKING_SPACES'=>$value[105],  
                    'GARAGE_TYPE'=>$value[106], 
                    'GARAGE_AREA'=>$value[107], 
                    'BASEMENT_TYPE'=>$value[108],   
                    'BASEMENT_AREA'=>$value[109],   
                    'AIR_CONDITIONING'=>$value[110],    
                    'HEAT_TYPE'=>$value[111],   
                    'HEAT_FUEL'=>$value[112],   
                    'PATIO_TYPE'=>$value[113],  
                    'PATIO_AREA'=>$value[114],  
                    'PORCH_AREA'=> $value[115], 
                    'PORCH_1_AREA'=>$value[116],    
                    'STYLE'=>$value[117],   
                    'ELECTRIC'=>$value[118],    
                    'ROOF_TYPE'=>$value[119],   
                    'ROOF_MATERIAL_TYPE'=>$value[120], 
                    'ROOF_FRAME'=>$value[121],  
                    'EXTERIOR_WALL'=>$value[122],   
                    'FLOOR_TYPE'=>$value[123],  
                    'FOUNDATION'=>$value[124],  
                    'CONSTRUCTION_TYPE'=>$value[125],   
                    'QUALITY'=>$value[126], 
                    'CONDITIONS'=>$value[127],  
                    'FRAME'=>$value[128],   
                    'EQUITY_VALUE'=>$value[129],
                    'EQUITY_PERCENTAGE'=>$value[130],   
                    'ESTIMATED_ALUE'=>$value[131],  
                    'LAND_USE'=>$value[132],    
                    'STATE_USE'=>$value[133],   
                    'COUNTY_LAND_USE'=>$value[134], 
                    'ZONING'=>$value[135],  
                    'LOT_AREA'=>$value[136],    
                    'LOT_ACREAGE'=>$value[137], 
                    'LOT_WIDTH'=>$value[138],   
                    'LOT_DEPTH'=>$value[139],   
                    'USABLE_LOT'=>$value[140],  
                    'USABLE_LOT_AREA'=>$value[141], 
                    'LOT_SHAPE'=>$value[142],   
                    'NO_RESIDENTIAL_UNITS'=>$value[143],    
                    'NO_COMMERCIAL_UNITS'=>$value[144], 
                    'NUMBER_OF_BUILDINGS'=>$value[145], 
                    'WATER_TYPE'=>$value[146],  
                    'SEWER_TYPE'=>$value[147],  
                    'VIEW_QUALITY'=>$value[148],    
                    'SITE_INFLUENCE'=>$value[149],  
                    'FLOOD_ZONE_CODE'=>$value[150], 
                    'FLOOD_MAP'=>$value[151],   
                    'FLOOD_PANEL'=>$value[152], 
                    'FLOOD_MAP_DATE'=>$value[153],  
                    'COMMUNITY_NAME'=>$value[154],  
                    'INSIDE_SFHA'=>$value[155], 
                    'ASSESSMENT_YEAR'=>$value[156], 
                    'TAX_YEAR'=>$value[157],    
                    'TAX_AREA'=>$value[158], 
                    'EXEMPT_DISABLED'=>$value[159], 
                    'EXEMPT_HOMESTEAD'=>$value[160],    
                    'EXEMPT_RELIGIOUS'=>$value[161],    
                    'EXEMPT_SCHOOL'=>$value[162],   
                    'EXEMPT_SENIOR'=>$value[163],   
                    'EXEMPT_UTILITIES'=>$value[164],    
                    'EXEMPT_VETERAN'=>$value[165],  
                    'EXEMPT_WIDOW'=>$value[166],    
                    'HOSPITAL_EXEMPTION'=>$value[167],  
                    'LIBRARY_EXEMPTION'=>$value[168],   
                    'MUSEUM_EXEMPTION'=>$value[169],    
                    'WELFARE_EXEMPTION'=>$value[170],   
                    'CEMETERY_EXEMPTION'=>$value[171],  
                    'ASSESSED_TOTAL_VALUE'=>$value[172],    
                    'ASSESSED_LAND_VALUE'=>$value[173], 
                    'ASSESSED_IMPROVEMENT_VALUE'=>$value[174],  
                    'ASSESSED_IMPROVEMENT_PERCENTAGE'=>$value[175], 
                    'MARKET_TOTAL_VALUE'=>$value[176],  
                    'MARKET_LAND_VALUE'=>$value[177],   
                    'MARKET_IMPROVEMENT_VALUE'=>$value[178],    
                    'MARKET_IMPROVEMENT_PERCENTAGE'=>$value[179],   
                    'APPRAISED_TOTAL_VALUE'=>$value[180],   
                    'APPRAISED_LAND_VALUE'=>$value[181],    
                    'APPRAISED_IMPROVEMENT_VALUE'=>$value[182], 
                    'APPRAISED_IMPROVEMENT_PERCENTAGE'=>$value[183],    
                    'PROPERTY_TAX'=>$value[184],    
                    'TOTAL_VALUE_TAXABLE'=>$value[185], 
                    'MARKET_VALUE'=>$value[186],    
                    'DELINQUENT_TAX_YR'=>$value[187],   
                    'SCHOOL_DISTRICT_1'=>$value[188],   
                    'SCHOOL_DISTRICT_2'=>$value[189],   
                    'SCHOOL_DISTRICT_3'=>$value[190],   
                    'ELEMENTARY_SCHOOL'=>$value[191],   
                    'MIDDLE_SCHOOL'=>$value[192],   
                    'HIGH_SCHOOL'=>$value[193], 
                    'OT_SALE_DATE'=>$value[194],    
                    'OT_RECORDING_DATE'=>$value[195],   
                    'OT_SALE_PRICE'=>$value[196],   
                    'OT_DEED_TYPE'=>$value[197],    
                    'OT_1ST_MTG_DOCUMENT'=>$value[198], 
                    'OT_DOCUMENT_NUMBER'=>$value[199],  
                    'LMS_SALE_DATE'=>$value[200],   
                    'LMS_RECORDING_DATE'=>$value[201],  
                    'LMS_SALE_PRICE'=>$value[202],  
                    'LMS_SALE_TYPE'=>$value[203],   
                    'LMS_DEED_TYPE'=>$value[204],   
                    'LMS_SELLER_NAME'=>$value[205], 
                    'LMS_PRICE_PER_SQFT'=>$value[206],  
                    'LMS_1ST_MTG_AMOUNT'=>$value[207],  
                    'LMS_1ST_MTG_TYPE'=>$value[208],    
                    'LMS_1ST_MTG_INT_RATE'=>$value[209],    
                    'LMS_1ST_MTG_INT_RATE_TYPE'=>$value[210],   
                    'LMS_1ST_MTG_DOCUMENT'=>$value[211],    
                    'LMS_2ND_MTG_AMOUNT'=>$value[212],  
                    'LMS_2ND_MTG_TYPE'=>$value[213],   
                    'LMS_2ND_MTG_INT_RATE'=>$value[214],    
                    'LMS_2ND_MTG_INT_RATE_TYPE'=>$value[215],   
                    'LMS_2ND_MTG_DOCUMENT'=>$value[216],    
                    'LMS_LENDER'=>$value[217],  
                    'LMS_TITLE_COMPANY'=>$value[218],   
                    'LMS_NEW_CONSTRUCTION'=>$value[219],    
                    'LMS_MULTI_SPLIT_SALE'=>$value[220],    
                    'LMS_DOCUMENT_NUMBER'=>$value[221], 
                    'PRIOR_SALE_DATE'=>$value[222], 
                    'PRIOR_REC_DATE'=>$value[223],  
                    'PRIOR_SALE_PRICE'=>$value[224],    
                    'PRIOR_DEED_TYPE'=>$value[225], 
                    'PRIOR_LENDER'=>$value[226],    
                    'PRIOR_1ST_MTG_AMOUNT'=>$value[227],    
                    'PRIOR_1ST_MTG_TYPE'=>$value[228],  
                    'PRIOR_1ST_MTG_RATE_TYPE'=>$value[229], 
                    'PRIOR_1ST_MTG_RATE'=>$value[230],  
                    'PRIOR_DOC_NUMBER'=>$value[231],    
                    'LINK'=>$value[232]   
                );
                $crm=Crm::firstOrCreate($check,$val);

                $prop=array(
                    'user_id'=>$request->get('user_id'),
                    'search_id'=>$request->get('id'),
                    'property_id'=>$crm->id
                );
                UserProperty::firstOrCreate($prop);

            }
        }
        Search::where('id',$request->get('id'))->update(['status'=>'1']);
        return Redirect::back()->withSuccess('Successfully Updated!!');
    }
}


