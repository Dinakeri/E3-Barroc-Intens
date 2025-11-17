<div>
    <flux:radio.group label="Status" name="status" class="mb-6 flex gap-2">
        <flux:radio value="new" label="New" description="Recently added clients awaiting first contact or setup." />
        <flux:radio value="active" label="Active" description="Clients currently under contract or receiving services." />
        <flux:radio value="pending" label="Pending"
            description="Clients in progress — awaiting approval or next steps." />
        <flux:radio value="inactive" label="Inactive"
            description="Former or paused clients with no ongoing activity." />
    </flux:radio.group>


    <flux:radio.group name="role" label="Role" variant="segmented">
        <flux:radio label="Admin" icon="wrench" />
        <flux:radio label="Editor" icon="pencil-square" />
        <flux:radio label="Viewer" icon="eye" />
    </flux:radio.group>

    <flux:radio.group label="Role">
        <flux:radio name="role" value="administrator" label="Administrator"
            description="Administrator users can perform any action." checked />
        <flux:radio name="role" value="editor" label="Editor"
            description="Editor users have the ability to read, create, and update." />
        <flux:radio name="role" value="viewer" label="Viewer"
            description="Viewer users only have the ability to read. Create, and update are restricted." />
    </flux:radio.group>
</div>
