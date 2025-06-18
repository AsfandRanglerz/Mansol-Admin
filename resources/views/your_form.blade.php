<input type="number" class="form-control" id="registration"
    name="registration"
    value="{{ old('registration', $HumanResource->registration) }}"
    readonly>
<input type="text" value="{{ optional($craft)->name }}" readonly
    class="form-control">
<input type="text" value="{{ $subCraft->name ?? null }}" readonly
    class="form-control">
<select name="approvals" class="form-control" disabled>
    // ...existing code...
</select>
<input type="file" class="form-control" id="medical_doc"
    name="medical_doc"
    accept=".pdf,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
    disabled>
<input type="text" class="form-control" id="name" name="name"
    value="{{ old('name', $HumanResource->name) }}" readonly>
<input type="text" class="form-control" id="son_of" name="son_of"
    value="{{ old('son_of', $HumanResource->son_of) }}" readonly>
<input type="text" class="form-control" id="mother_name"
    name="mother_name"
    value="{{ old('mother_name', $HumanResource->mother_name) }}" readonly>
<select name="blood_group" class="form-control" disabled>
    // ...existing code...
</select>
<input type="date" class="form-control" id="date_of_birth"
    name="date_of_birth"
    value="{{ old('date_of_birth', $HumanResource->date_of_birth) }}" readonly>
<select name="city_of_birth" class="form-control" id="citySelect" disabled>
    // ...existing code...
</select>
<input type="number" class="form-control" id="cnic" name="cnic"
    value="{{ old('cnic', $HumanResource->cnic) }}" readonly>
<input type="date" class="form-control" id="cnic_expiry_date"
    name="cnic_expiry_date"
    value="{{ old('cnic_expiry_date', $HumanResource->cnic_expiry_date) }}" readonly>
<input type="text" class="form-control" id="passport"
    name="passport"
    value="{{ old('passport', $HumanResource->passport) }}" readonly>
<select name="passport_issue_place" class="form-control" disabled>
    // ...existing code...
</select>
<input type="date" class="form-control" id="doi" name="doi"
    value="{{ old('doi', $HumanResource->doi) }}" readonly>
<input type="date" class="form-control" id="doe" name="doe"
    value="{{ old('doe', $HumanResource->doe) }}" readonly>
<select name="religion" class="form-control" disabled>
    // ...existing code...
</select>
<select name="martial_status" id="martial_status" class="form-control" disabled>
    // ...existing code...
</select>
<input type="text" class="form-control" id="next_of_kin"
    name="next_of_kin"
    value="{{ old('next_of_kin', $HumanResource->next_of_kin) }}" readonly>
<select class="form-control" id="relation" name="relation" disabled>
    // ...existing code...
</select>
<input type="number" class="form-control" id="kin_cnic"
    name="kin_cnic"
    value="{{ old('kin_cnic', $HumanResource->kin_cnic) }}" readonly>
<select name="shoe_size" class="form-control" disabled>
    // ...existing code...
</select>
<select name="cover_size" id="cover_size" class="form-control" disabled>
    // ...existing code...
</select>
<select name="acdemic_qualification" id="acdemic_qualification"
    class="form-control" disabled>
    // ...existing code...
</select>
<select name="technical_qualification" id="qualification"
    class="form-control" disabled>
    // ...existing code...
</select>
<input type="number" name="experience_local" class="form-control"
    min="0" placeholder="Enter Years of Experience"
    value="{{ old('experience', $HumanResource->experience_local ?? '') }}" readonly>
<input type="number" name="experience_gulf" class="form-control"
    min="0" placeholder="Enter Years of Experience"
    value="{{ old('experience', $HumanResource->experience_gulf ?? '') }}" readonly>
<select name="district_of_domicile" id="district_of_domicile"
    class="form-control" disabled>
    // ...existing code...
</select>
<textarea type="text" class="form-control" id="present_address" name="present_address" readonly>{{ old('present_address', $HumanResource->present_address) }}</textarea>
<input type="tel" class="form-control" id="present_address_phone"
    name="present_address_phone"
    value="{{ old('present_address_phone', $HumanResource->present_address_phone) }}" readonly>
<input type="tel" class="form-control"
    id="present_address_mobile" name="present_address_mobile"
    value="{{ old('present_address_mobile', $HumanResource->present_address_mobile) }}" readonly>
<input type="email" class="form-control"
    value="{{ $HumanResource->email }}" readonly>
<select name="present_address_city" id="present_address_city"
    class="form-control" disabled>
    // ...existing code...
</select>
<textarea type="text" class="form-control" id="permanent_address" name="permanent_address" readonly>{{ old('permanent_address', $HumanResource->permanent_address) }}</textarea>
<input type="tel" class="form-control"
    id="permanent_address_phone" name="permanent_address_phone"
    value="{{ old('permanent_address_phone', $HumanResource->permanent_address_phone) }}" readonly>
<input type="tel" class="form-control"
    id="permanent_address_mobile" name="permanent_address_mobile"
    value="{{ old('permanent_address_mobile', $HumanResource->permanent_address_mobile) }}" readonly>
<select name="permanent_address_city" id="permanent_address_city"
    class="form-control" disabled>
    // ...existing code...
</select>
<select name="permanent_address_province" class="form-control" disabled>
    // ...existing code...
</select>
<select name="citizenship" class="form-control" disabled>
    // ...existing code...
</select>
<select name="gender" id="gender" class="form-control" disabled>
    // ...existing code...
</select>
<input type="text" class="form-control" id="refference"
    name="refference"
    value="{{ old('refference', $HumanResource->refference) }}" readonly>
<input type="text" class="form-control" id="performance_appraisal"
    name="performance_appraisal"
    value="{{ old('performance_appraisal', $HumanResource->performance_appraisal) }}" readonly>
<select name="currancy" class="form-control" id="currancy" disabled>
    // ...existing code...
</select>
<input type="number" class="form-control" id="min_salary"
    name="min_salary" value="{{ $HumanResource->min_salary }}" readonly>
<input type="text" class="form-control" id="comment" name="comment"
    value="{{ old('comment', $HumanResource->comment) }}" readonly>
<select name="status" class="form-control" disabled>
    // ...existing code...
</select>