<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDemographicProfileRequest;
use App\Http\Resources\YouthProfileResource;
use App\Models\YouthProfile;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DemographicProfileController extends Controller
{
    use AuthorizesRequests;

    public function index(): Response
    {
        $youthprofiles = YouthProfile::with('demographic')->get();

        return Inertia::render('Admin/DemographicProfiles/DemographicProfileIndex', [
            'youthprofiles' => YouthProfileResource::collection($youthprofiles)
        ]);
    }

    public function create(): Response
    {
        $this->authorize('create', YouthProfile::class);
        return Inertia::render('Admin/DemographicProfiles/Create');
    }

    public function store(CreateDemographicProfileRequest $request): RedirectResponse
    {
        $this->authorize('create', YouthProfile::class);

        $validatedData = $request->validated();
        $youthProfileData = array_intersect_key($validatedData, array_flip([
            'first_name', 'middle_name', 'last_name', 'suffix', 'region', 'province',
            'municipality', 'baranggay', 'purok', 'sex', 'age', 'birthdate', 'email', 'contact_no'
        ]));

        $demographicData = array_intersect_key($validatedData, array_flip([
            'civil_status', 'youth_age_group', 'educational_background', 'youth_classification',
            'specific_needs_detail', 'work_status', 'registered_sk_voter', 'registered_national_voter',
            'sk_assembly', 'sk_assembly_times_attended', 'sk_assembly_not_attended', 'vote_last_sk_election'
        ]));

        $youthProfile = YouthProfile::create($youthProfileData);
        $youthProfile->demographic()->create($demographicData);

        return redirect()->route('youthprofiles.index');
    }

    public function edit(YouthProfile $youthprofile): Response
    {
        $this->authorize('update', $youthprofile);

        return Inertia::render('Admin/DemographicProfiles/Edit', [
            'youthprofile' => new YouthProfileResource($youthprofile->load('demographic'))
        ]);
    }

    public function update(CreateDemographicProfileRequest $request, YouthProfile $youthprofile): RedirectResponse
    {
        $this->authorize('update', $youthprofile);

        $validatedData = $request->validated();
        $youthProfileData = array_intersect_key($validatedData, array_flip([
            'first_name', 'middle_name', 'last_name', 'suffix', 'region', 'province',
            'municipality', 'baranggay', 'purok', 'sex', 'age', 'birthdate', 'email', 'contact_no'
        ]));

        $demographicData = array_intersect_key($validatedData, array_flip([
            'civil_status', 'youth_age_group', 'educational_background', 'youth_classification',
            'specific_needs_detail', 'work_status', 'registered_sk_voter', 'registered_national_voter',
            'sk_assembly', 'sk_assembly_times_attended', 'sk_assembly_not_attended', 'vote_last_sk_election'
        ]));

        $youthprofile->update($youthProfileData);
        if ($youthprofile->demographic) {
            $youthprofile->demographic->update($demographicData);
        } else {
            $youthprofile->demographic()->create($demographicData);
        }

        return redirect()->route('youthprofiles.index');
    }

    public function destroy(YouthProfile $youthprofile): RedirectResponse
    {
        $this->authorize('delete', $youthprofile);
        $youthprofile->delete();
        return back();
    }
}




