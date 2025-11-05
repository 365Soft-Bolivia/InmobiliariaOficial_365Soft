<?php

namespace Database\Seeders;

use App\Models\LeadPipeline;
use App\Models\PipelineStage;
use Illuminate\Database\Seeder;

class PipelinePurposeAndPublicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Nota: seguimos el patrón del proyecto, recibiendo companyId vía $this->call(..., ['companyId' => X])
     */
    public function run($companyId)
    {
        // Detectar pipelines por compañía
        $pipelines = LeadPipeline::where('company_id', $companyId)->get();

        foreach ($pipelines as $pipeline) {
            $name = mb_strtolower((string) $pipeline->name);
            $slug = mb_strtolower((string) $pipeline->slug);

            $purpose = $pipeline->purpose;

            // Heurística: captación si name/slug contiene 'capt', ventas si contiene 'venta'
            if (str_contains($slug, 'capt') || str_contains($name, 'capt')) {
                $purpose = 'captacion';
            } elseif (str_contains($slug, 'venta') || str_contains($name, 'venta')) {
                $purpose = 'ventas';
            }

            if ($purpose !== $pipeline->purpose) {
                $pipeline->purpose = $purpose;
                $pipeline->save();
            }

            // Para el pipeline de captación, marcar penúltima etapa como makes_public
            if ($pipeline->purpose === 'captacion') {
                $stages = PipelineStage::where('company_id', $companyId)
                    ->where('lead_pipeline_id', $pipeline->id)
                    ->orderBy('priority', 'asc')
                    ->get();

                if ($stages->count() >= 2) {
                    $penultimate = $stages[$stages->count() - 2];

                    // Limpiar flags y marcar solo la penúltima
                    PipelineStage::where('company_id', $companyId)
                        ->where('lead_pipeline_id', $pipeline->id)
                        ->where('id', '!=', $penultimate->id)
                        ->update(['makes_public' => false]);

                    if ($penultimate->makes_public !== true) {
                        $penultimate->makes_public = true;
                        $penultimate->save();
                    }
                }
            }
        }
    }
}

