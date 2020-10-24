<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Clients\BitrixClient;
use App\Models\OnlineModels\CalculationResult;
use App\Models\OnlineModels\FormField;
use App\Models\OnlineModels\FormOption;
use App\Models\Offer;
use App\Http\Requests\OfferUpdateRequest;

class ProposalController extends Controller
{
    public function __construct(BitrixClient $bitrixClient)
    {
        $this->bitrixClient = $bitrixClient;
    }
    
    public function getOrCreate(Request $request)
    {
        $dealId = '195';
        $offer = Offer::where('deal_id', '=', $dealId)->first();
        if(!$offer)
        {
            $deal = $this->bitrixClient->getDeal($dealId);
            $lead = $this->bitrixClient->getLead($deal['LEAD_ID']);
            $calculationResult = CalculationResult::where('bitrix_id', '=', $deal['LEAD_ID'])->first();
            $requestData = json_decode($calculationResult->request_data);
            $resultData = json_decode($calculationResult->result_data);
            $import = $resultData->import;
            $offer = new Offer;
            $offer->request_id = $calculationResult->request_id;
            $offer->lead_id =  $deal['LEAD_ID'];
            $offer->deal_id = $dealId;
            $offer->project_name = $deal['TITLE'];
            $offer->project_type = $this->getProjectType($requestData->{343});
            $offer->advance = $import->advance;
            $offer->leasing_term = $import->{'leasing-term'};
            $offer->amount_of_financing = $import->financing;
            $offer->leasing_object_name = $this->getLeasingObjectName($requestData);
            $offer->quantity = $requestData->{360};
            $offer->insurance_program = $this->getInsuranceProgram($requestData->{387});
            $offer->franchise = $this->getFranshize($requestData->{388});
            $offer->lead_source = $this->getRequestSource($requestData->{347});

            $offer->agent_info = $this->getAgentInfo($lead['UF_CRM_1571249490'], $requestData->{397});

            $offer->leasing_amount_dkp = $requestData->{353};
            $offer->preliminary_financing = $this->getPreliminaryFinancing($requestData->{411});
            $offer->gps_tracker = $this->getGpsTracker($requestData->{370});
            $supplier = $this->getContact($deal['UF_CRM_1591689880'], $deal['UF_CRM_1585318081']);
            if($supplier['supplier_type'] === 1){
                $offer->supplier_name = $supplier['name'];
                $offer->contact_name = $supplier['name'];
                $offer->contact_position = $supplier['post'];
                $offer->contact_phone = $supplier['phone'];
                $offer->contact_email = $supplier['email'];
                $offer->supplier_type = $supplier['supplier_type'];
            }elseif($supplier['supplier_type'] === 2){
                $offer->supplier_name = $supplier['company_name'];
                $offer->supplier_type = $supplier['supplier_type'];
            }
            $offer->fuel_card_agreement = $requestData->{372};
            $offer->start_date = $requestData->{416};
            $offer->real_owner = $this->getBeneficiary($deal['COMPANY_ID']);
            $offer->beneficiary = $this->getBeneficiary($deal['COMPANY_ID']);
            $offer->front_manager = $this->bitrixClient->getManagerName($deal['UF_CRM_1591005132']);
            $offer->middle_manager = $this->bitrixClient->getManagerName($deal['UF_CRM_1591005153']);
            $offer->save();
        }

        return response()->json($offer);
    }

    private function getProjectType($id)
    {
        $formOption = FormOption::where('type_id', '=', 72)->where('id', '=', $id)->first();

        return $formOption->name;
    }

    private function getLeasingObjectName($requestData)
    {
        $leasingObject = "{$requestData->{348}} {$requestData->{349}}";
        if(property_exists($requestData, 421)){
            $leasingObject = "{$leasingObject}  {$requestData->{421}}";
        }
        if(property_exists($requestData, 422)){
            $fuelType = $this->getFuelType($requestData->{422});
            $leasingObject = "{$leasingObject}  {$fuelType}";
        }
        if(property_exists($requestData, 423)){
            $kppType = $this->getKppType($requestData->{423});
            $leasingObject = "{$leasingObject}  {$kppType}";
        }
        $leasingObject = "{$leasingObject}  {$requestData->{351}} куб. см.";

        return $leasingObject;
    }

    private function getInsuranceProgram($id)
    {
        $formOption = FormOption::where('type_id', '=', 81)->where('id', '=', $id)->first();

        return $formOption->name;
    }

    private function getFranshize($id)
    {
        $formOption = FormOption::where('type_id', '=', 82)->where('id', '=', $id)->first();

        return $formOption->name;
    }

    private function getRequestSource($id)
    {
        $formOption = FormOption::where('type_id', '=', 77)->where('id', '=', $id)->first();

        return $formOption->name;
    }

    private function getGpsTracker($id)
    {
        $formOption = FormOption::where('type_id', '=', 79)->where('id', '=', $id)->first();

        return $formOption->name;
    }

    private function getPreliminaryFinancing($sum)
    {
        $result = 'нi';

        if($sum !== '0')
        {
            $result = 'так';
        }

        return $result;
    }

    private function getContact($contactId = null, $companyId = null)
    {
        $result = [];
        if($contactId){
            $contact = $this->bitrixClient->getContact($contactId);
            $result = [
                'name' => "{$contact['LAST_NAME']}  {$contact['NAME']}  {$contact['SECOND_NAME']}",
                'post' =>  $contact['POST'] ?? '-',
                'phone' => $contact['PHONE'][0]['VALUE'],
                'email' => $contact['EMAIL'][0]['VALUE'],
                'supplier_type' => 1,
            ];
        }elseif($companyId){
            $company = $this->bitrixClient->getCompany($companyId);
            $result['supplier_type'] = 2;
            $result['company_name'] = $company['TITLE'];
        }
        
       return $result;
    }

    private function getBeneficiary($companyId = null)
    {
        $beneficiary = '-';
        if($companyId)
        {
            $company = $this->bitrixClient->getCompany($companyId);
            if($company['UF_CRM_1586514084'])
            {
                $contactId = reset($company['UF_CRM_1586514084']);
                $contact = $this->bitrixClient->getContact($contactId);
                $beneficiary = "{$contact['LAST_NAME']}  {$contact['NAME']}  {$contact['SECOND_NAME']}";
            }
        }
        
        return $beneficiary;
    }

    public function getCompanyUsers($dealId)
    {
        $deal = $this->bitrixClient->getDeal($dealId);
        $users = $this->bitrixClient->getCompanyContacts($deal['COMPANY_ID']);
        foreach($users as $user)
        {
            $contact = $this->bitrixClient->getContact($user['CONTACT_ID']);
            $result[] = [
                'name' => "{$contact['LAST_NAME']}  {$contact['NAME']}  {$contact['SECOND_NAME']}",
                'post' =>  $contact['POST'] ?? '-',
                'phone' => $contact['PHONE'][0]['VALUE'],
                'email' => $contact['EMAIL'][0]['VALUE'] ?? '-',
            ];
        }

        return response()->json($result);
    }

    public function getAgentInfo($agentId, $commision = null)
    {
        $agentInfo = '-';
        if($agentId){
            $agent = $this->bitrixClient->getContact($agentId);
            $agentInfo = "{$agent['LAST_NAME']}  {$agent['NAME']}  {$agent['SECOND_NAME']} {$commision}%";
        }

        return $agentInfo;
    }

    public function update(OfferUpdateRequest $request)
    {
        $data = $request->validated();
        $offer = Offer::find($data['offer_id']);
        $offer->update($data);

        return response()->json($offer);
    }
}
