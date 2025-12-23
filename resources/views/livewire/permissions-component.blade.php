<div>
    <div style="padding: 16px;">
        <p style="color: #666; margin-bottom: 20px; font-size: 0.875rem;">
            Permissions are system-defined and cannot be modified. They are automatically assigned to roles.
        </p>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
            @foreach($this->groupedPermissions as $resource => $permissions)
                <div style="background: #f9f9f9; border-radius: 8px; padding: 16px;">
                    <h3 style="font-size: 1rem; font-weight: 600; text-transform: capitalize; margin-bottom: 12px; color: #333; border-bottom: 2px solid #007bff; padding-bottom: 8px;">
                        {{ $resource }}
                    </h3>
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        @foreach($permissions as $permission)
                            <div style="display: flex; align-items: center; gap: 8px; padding: 6px 10px; background: #fff; border-radius: 4px; border: 1px solid #e0e0e0;">
                                <span style="width: 8px; height: 8px; background: #007bff; border-radius: 50%;"></span>
                                <span style="font-size: 0.8rem; color: #444;">{{ $permission->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
