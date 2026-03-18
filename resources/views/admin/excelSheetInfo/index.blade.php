@extends('admin.layout.app')
@section('title', 'Excel Sheet Protocol')
@section('content')

<div class="main-content" style="min-height: 562px;">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">

                        <div class="card-header">
                            <div class="col-12">
                                <h4>Import Instructions For Excel Sheet</h4>
                            </div>
                        </div>

                        <div class="card-body text-danger">
                            <ul>
                                <li><strong>CNIC</strong> must be <strong>13 digits</strong> and must be <strong>unique for each record</strong>.</li>
                                <li><strong>Passport number</strong> must also be <strong>unique for each record</strong>.</li>
                                <li><strong>Company name</strong> in the sheet must exactly match the company name available in the <strong>Admin Panel</strong>.</li>
                                <li><strong>Project name</strong> in the sheet must exactly match the project name available in the <strong>Admin Panel</strong>.</li>
                                <li><strong>Craft name</strong> in the sheet must exactly match the craft name available in the <strong>Admin Panel</strong>.</li>
                                <li><strong>Sub-Craft name</strong> in the sheet must exactly match the sub-craft name available in the <strong>Admin Panel</strong>.</li>
                                <li><strong>Demand</strong> will only be used if it exists for the selected <strong>Company + Project</strong> in the Admin Panel.</li>
                                <li>All fields that are <strong>mandatory in the Admin Panel</strong> must also be <strong>filled in the Excel sheet</strong> and cannot be empty.</li>
                                <li>For unassigned human resources, <strong>the company, project, demand, craft, and sub-craft</strong> fields should be left blank.</li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('js')

@endsection