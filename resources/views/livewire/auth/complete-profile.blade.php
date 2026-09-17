<div class="max-w-2xl mx-auto py-12">
    <div class="bg-white rounded-xl shadow-md p-8 border border-gray-100">
        <h2 class="text-2xl font-bold text-unhcr-dark mb-6 text-center">Complétez votre profil</h2>
        <p class="text-gray-600 mb-8 text-center">Veuillez sélectionner votre organisation et votre province pour finaliser votre inscription. Un administrateur validera ensuite votre accès pour la création d'activités.</p>

        <form wire:submit.prevent="save">
            <div class="mb-6">
                <label for="organisation_id" class="block text-sm font-medium text-gray-700 mb-2">Organisation</label>
                <select id="organisation_id" wire:model="organisation_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-unhcr-blue focus:ring focus:ring-unhcr-lightblue focus:ring-opacity-50 text-gray-900 py-2 px-3 border" required>
                    <option value="">-- Sélectionnez une organisation --</option>
                    @foreach($organisations as $org)
                        <option value="{{ $org->id }}">{{ $org->denomination }}</option>
                    @endforeach
                </select>
                @error('organisation_id') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mb-8">
                <label for="province_id" class="block text-sm font-medium text-gray-700 mb-2">Province</label>
                <select id="province_id" wire:model="province_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-unhcr-blue focus:ring focus:ring-unhcr-lightblue focus:ring-opacity-50 text-gray-900 py-2 px-3 border" required>
                    <option value="">-- Sélectionnez une province --</option>
                    @foreach($provinces as $prov)
                        <option value="{{ $prov->id }}">{{ $prov->nom_province }}</option>
                    @endforeach
                </select>
                @error('province_id') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-center">
                <button type="submit" class="bg-unhcr-blue hover:bg-unhcr-dark text-white font-medium py-2.5 px-6 rounded-md transition shadow-sm inline-flex items-center">
                    <span wire:loading.remove>Enregistrer et continuer</span>
                    <span wire:loading>Enregistrement...</span>
                </button>
            </div>
        </form>
    </div>
</div>
