<?php

namespace App\Traits;

trait APIResponseManager {

    /**
     * 
     * @param type $requestStatus  i.e "success/error"
     * @param type $statusCode     i.e "success/error"
     * @param type $collectionKey  i.e  key value ==>   "'user'=>$data"
     * @param type $collectionValue
     * @return type
     */
    public function responseManager($requestStatus, $statusCode, $collectionKey = null, $collectionValue = null, $statusMessage = null) {
        switch ($requestStatus) {
            // 1. ::: CASE SECCUSS 
            case Config('statuscodes.request_status.SUCCESS') :
                if (isset($collectionKey) && !empty($collectionKey)) {
                    return response()->json([$collectionKey => $collectionValue,
                                'status' => Config('statuscodes.request_status.SUCCESS'),
                                'status_code' => Config('statuscodes.success_codes.' . $statusCode),
                                'status_message' => Config('statuscodes.success_messages.' . $statusCode)]);
                }if (isset($statusMessage) && !empty($statusMessage)) {
                     return response()->json([
                                'status' => Config('statuscodes.request_status.SUCCESS'),
                                'status_code' => Config('statuscodes.success_codes.' . $statusCode),
                                'status_message' => $statusMessage]);
                } else {
                    return response()->json([
                                'status' => Config('statuscodes.request_status.SUCCESS'),
                                'status_code' => Config('statuscodes.success_codes.' . $statusCode),
                                'status_message' => Config('statuscodes.success_messages.' . $statusCode)]);
                }

                break;

            // 2. ::: CASE FAILURE    
            case Config('statuscodes.request_status.ERROR'):

                // TODO :: Need to use exception / error details

                if (isset($collectionKey) && !empty($collectionKey)) {
                    return response()->json([$collectionKey => $collectionValue,
                                'status' => Config('statuscodes.request_status.ERROR'),
                                'status_code' => Config('statuscodes.error_codes.' . $statusCode),
                                'status_message' => is_array($collectionValue)?$collectionValue[0]:Config('statuscodes.error_messages.' . $statusCode)]);
                } else {
                    return response()->json([
                                'status' => Config('statuscodes.request_status.ERROR'),
                                'status_code' => Config('statuscodes.error_codes.' . $statusCode),
                                'status_message' => Config('statuscodes.error_messages.' . $statusCode)]);
                }
                break;
        }
    }
}
