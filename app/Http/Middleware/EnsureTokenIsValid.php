<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public const VALID_TOKENS = [
        'admin' => 'c9PNuT4?4dBhH=8Ws=o9vd=9Fggagkib0dgDtdUpGsejD5zC8?hMq?zfOAHS/ooBEdpX5qm!eotL?gEb1FhkGWc8KNuf6?G8uJo1M2EIWJdp1EL!CLMDRJbcpNYsptj4EYx4vP0D8bi?XoGp0t2QHg/ZB=/DMybNgAxPIzR!WDVYjbRKQJgqeZ53FBIttqiT=A!lkoQZXktl/NitvF?806jLHHjyisoh-6!WncxIpZay6=fg5SNNwpqPLTaVIJ3n',
        'ON1' => 'nOXaVvx4Uozua3scGNIMbCYpX3iYaN94GV=VyOihbkmHWtA0XsPEL/5e?zMLTch!AgkwuHyWCdkB2tQzrEm1F0hkTi=1G8SnkFb9O!O3O49/u/mGh48qbHczkPgaLMiazQSKkES5hLEOwhV8oX8dFlhtRyY-SeGHFtT3GTADQ7in3wQaoHz6EQyl=DpO/=5?TXQ/gXEr?WS!Thfw-GRv-EzKAVHB47=urQRvLXYucibAjW2sJHskUZi9UJZAvqwl',
        'ON2' => 'uLAYesZPdNn6lVqpIKbwlUSUy/uwOJ?x1H!bANlFYd7AYtwLz/U0XDehRUGqf=ChEfpSVdDiQO0pD2QUWZ8?KxVFXM3qpYta5oQhkL0SrLmjwc2x/ha?6ovfTI76-VQ5ZKyD8U1GUeh5f41?FT3Ctv21z8tAsiIM5Qbqxl7ISaWqosiA/E4n=Tk7MZk=2?mj=mT15ijn2VppgK0wSuSZBZbB8V2ZCS7PCqF2f!/oGAbKKhhG92cADq1WYNTa20iF0',
        'UE1' => 'espwk!53pxwCbEaeaYUUFRz==SOfh!W!upFc7goSY08nTKJlvvyOZPPlh8=TWuzbHyCmnh5xica?3BwyaP8nSC8durhZRhyL=P-BgM5aryn2=z?Qfyh!vAfp2U2CCMM-G4CIIxR7K3G-wvq0oEwZXMhIBx35nB83qvoT2WSZ4liNGCoFI6PbO7c40ZF2CI50NOs7VMLszxh2lXAL3cc/FslKQmk92=vS=Y=BBqcoquw?Tjh98pe6YJGA9VSdm1yT',
        'UE2' => 'BvafTK4UR!M/p7ploDcHm3?tl7?YgT!!IlBfw914K40a-!bznwJytg4zpv//H7HPSqiPkdb!eoFsqqZNGhkqLgGCWBigHEbDrnW/Mpj=ed5eRVK8E5vyHw/yln=7rR2pNF4SfAy-NGy1I-H01flzg6Cnu5Ftr4KTOYeUGbpwT6Z7OT!VFVn15v3hn9-08sQIpGtwM7321BXVhioKY99LhySeqbCP=wfPVxjpLOLYSVKz8WWDrkuH?aTn8xXvhR/S',
        'KT1' => 'Pdnham7LkgtnsGhtEEHSdKL9PoCx4S?pWIy7yIkult3k1NgrZ959m6l8xa-6lxlpvyxLmsJ4ix5fCPphXgJ0NMyfl7V7?v?0x3hKGRm4AJF9chTV!=TX8nh!AeLCXs6rpWl9IeFZMG!BvWOORh/6KMfb1WcxQzpLWvv5R-EP9rfCse=Y4XMLBuEY?g?2!ki8yf7I0zfxhUEBmyn5buxLsCFQuqpNXUrH03OLwhiVezLvxbt875dhlGLhf/C4F9KU',
        'QR1' => 'ozMqsgfGn8?cBfebE8ssY1E!kyJppquMyKyF4ARR7Uvk7F80t/FRcwKB77qU4--xgXP/=VWp?6lm-RA49mjjV7h124Mw47gK=MZcNSl4z5rg5Eq1fZYKeWRqUhqGmAA8GmnT4k8KzGdlYRliUD6Z2jqyj7Dy9tScFToVr7TGxx7tVaOBr1RpnXkFqAIXa?/Ra4jKCJTWx==g8jXk?MzYfzM8mGE7pSlYih09tKOHfikRcsKA6gFHIWAsevNi22Zt',
        'BN1' => '6dwZcscjVbWlZmj3uupfSbjib25jJ8O/8Cl0Rt8jP/AyDK4hIzDbxY/r?loO0ztl8xnPgg?cJ1iUb2DnZUCz3f5n3S2WyV?MTnBr5tvpyBFM=2VwZ70Sracz0iz=oK2/aQH96/lQM5qgUYuLQ?yBu63NUC6c?uuvVB8CkMmBxKbgPsRIcf8-4fxLAoISUQGYeNGeam9kchA0SVc9qy!i1tUtiCFhT09W9Z2?7He4lwOVwyh-/VD6P-dwoPp-fM40',
    ];
    public function handle(Request $request, Closure $next)
    {
        $authHeader = $request->header('authorization-token');
        if (!$authHeader) {
            return response('unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        $validTokens = static::VALID_TOKENS;

        if ($authHeader == $validTokens['admin']) {
            return $next($request);
        }

        //check for protected routes
        $uri = $request->route()->uri;
        if ($request->isMethod('delete') and $uri == 'api/centers/{center}/patients/{id}') {
            if ($authHeader !== $validTokens['admin']) {
                return response('unauthorized', Response::HTTP_UNAUTHORIZED);
            }
        } elseif ($uri == 'api/patients') {
            if ($authHeader !== $validTokens['admin']) {
                return response('unauthorized', Response::HTTP_UNAUTHORIZED);
            }
        } else {
            $center = $request->route()->parameters['center'];
            if (!$center) {
                return response('unauthorized for unknown center', Response::HTTP_UNAUTHORIZED);
            }

            $center = strtoupper($center);
            if ($authHeader !== $validTokens[$center]) {
                return response('unauthorized', Response::HTTP_UNAUTHORIZED);
            }
        }

        return $next($request);
    }
}
