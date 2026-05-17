<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContactEnquiryUpdateRequest;
use App\Models\ContactEnquiry;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ContactEnquiryController extends Controller
{
    public function index(): View
    {
        $type = request('type');
        $status = request('status');
        $search = trim((string) request('search'));
        $from = request('from');
        $to = request('to');

        $enquiries = ContactEnquiry::query()
            ->when($type, fn ($query) => $query->where('type', $type))
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($from, fn ($query) => $query->whereDate('created_at', '>=', $from))
            ->when($to, fn ($query) => $query->whereDate('created_at', '<=', $to))
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('enquiry_no', 'like', "%{$search}%")
                        ->orWhere('organization', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.enquiries.index', [
            'pageTitle' => 'General Enquiries',
            'breadcrumb' => 'Enquiries',
            'enquiries' => $enquiries,
            'typeOptions' => $this->typeOptions(),
            'statusOptions' => $this->statusOptions(),
            'filters' => compact('type', 'status', 'search', 'from', 'to'),
        ]);
    }

    public function show(ContactEnquiry $enquiry): View
    {
        return view('admin.enquiries.show', [
            'pageTitle' => 'Enquiry Details',
            'breadcrumb' => 'Enquiries / Details',
            'enquiry' => $enquiry,
            'typeOptions' => $this->typeOptions(),
            'statusOptions' => $this->statusOptions(),
        ]);
    }

    public function update(ContactEnquiryUpdateRequest $request, ContactEnquiry $enquiry): RedirectResponse
    {
        $data = $request->validated();

        if ($data['status'] === 'contacted' && ! $enquiry->contacted_at) {
            $data['contacted_at'] = now();
        }

        if ($data['status'] === 'closed' && ! $enquiry->closed_at) {
            $data['closed_at'] = now();
        }

        $enquiry->update($data);

        return redirect()->route('admin.enquiries.show', $enquiry)->with('status', 'Enquiry updated.');
    }

    public function destroy(ContactEnquiry $enquiry): RedirectResponse
    {
        $enquiry->delete();

        return redirect()->route('admin.enquiries.index')->with('status', 'Enquiry deleted.');
    }

    /**
     * @return array<string, string>
     */
    private function typeOptions(): array
    {
        return [
            'general' => 'General Enquiry',
            'csr_partner' => 'CSR Partnership',
            'volunteer' => 'Volunteer',
            'visit_request' => 'Visit Request',
            'collaboration' => 'Collaboration',
            'training_help' => 'Training Help',
            'other' => 'Other',
        ];
    }

    /**
     * @return array<string, string>
     */
    private function statusOptions(): array
    {
        return [
            'new' => 'New',
            'contacted' => 'Contacted',
            'in_progress' => 'In Progress',
            'closed' => 'Closed',
            'rejected' => 'Rejected',
        ];
    }
}
