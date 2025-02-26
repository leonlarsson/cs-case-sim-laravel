import { AboutButtonWithModal } from '@/components/about-button-with-modal';
import { Button } from '@/components/button';
import CaseItems from '@/components/case-items';
import { CasePicker } from '@/components/case-picker';
import casesLocal from '@/data/cases.json';
import customCasesLocal from '@/data/customCases.json';
import souvenirCasesLocal from '@/data/souvenir.json';
import AppLayout from '@/layouts/app-layout';
import { APICase, CasePickerCase } from '@/types';
import { Head } from '@inertiajs/react';

// Just get the metadata for the cases
// Used in the CasePicker component and for the page title
const casesMetadata: CasePickerCase[] = [...casesLocal.toReversed(), ...customCasesLocal, ...souvenirCasesLocal.toReversed()].map((x) => ({
    id: x.id,
    name: x.name,
    description: x.description,
    image: x.image,
    first_sale_date: x.first_sale_date,
}));

// Combine the case data arrays
// This is not visual at all, so the order doesn't matter
// The only place where the order matters is in the CasePicker component, which uses the casesMetadata array above
const casesData: APICase[] = [
    // ...cases,
    ...casesLocal,
    ...customCasesLocal,
    ...souvenirCasesLocal,
    // ...souvenirPackages,
];

export default function Welcome() {
    const selectedCaseParam = new URLSearchParams(window.location.search).get('case');
    const selectedCaseName = casesMetadata.find((x) => x.id === selectedCaseParam)?.name;

    const selectedCase = casesData.find((x) => x.id === (selectedCaseParam ?? 'crate-7003')) ?? casesData[0];

    return (
        <AppLayout>
            {selectedCaseName && <Head title={selectedCaseName} />}
            <main id="main" className="relative flex min-h-screen flex-col select-none">
                {/* Header row */}
                <div className="mx-2 mt-2 flex flex-col-reverse justify-between gap-2 min-[800px]:flex-row">
                    <CasePicker availableCases={casesMetadata} />

                    <Button variant="secondary-darker" href="/unboxed" className="flex items-center justify-center py-0 text-center backdrop-blur-md">
                        Global Unbox History
                    </Button>
                </div>

                {/* Case display */}
                <div className="mt-3 flex flex-1 flex-col items-center gap-1 text-center">
                    <h1 className="text-4xl font-medium text-white">Unlock Container</h1>
                    <h4 className="text-xl">
                        Unlock <span className="font-semibold">{selectedCase.name}</span>
                        <span className="hidden max-[500px]:inline [@media_(max-height:500px)]:inline">
                            {' '}
                            <img className="inline" src={selectedCase.image} alt={`${selectedCase.name} image`} width={48} draggable={false} />
                        </span>
                    </h4>

                    <img
                        className="block max-[500px]:hidden [@media_(max-height:500px)]:hidden"
                        src={selectedCase.image}
                        alt={`${selectedCase.name} image`}
                        width={256 / 1.7}
                        height={256 / 1.7}
                        draggable={false}
                    />
                </div>

                {/* Item display */}
                <div className="flex flex-col backdrop-blur-md">
                    <div className="my-2 px-4 lg:px-12">
                        <div className="flex items-center justify-between">
                            <span className="text-lg tracking-wider">Contains one of the following:</span>
                            <AboutButtonWithModal />
                        </div>
                        <hr className="my-2 opacity-30" />
                    </div>

                    <div className="flex max-h-96 flex-wrap gap-8 overflow-auto px-4 pb-2 max-[500px]:flex-nowrap min-[800px]:px-16 [@media_(max-height:500px)]:flex-nowrap [@media_(max-height:500px)]:px-8">
                        <CaseItems items={selectedCase.contains} rareItems={selectedCase.contains_rare} />
                    </div>

                    <hr className="container mx-auto my-5 px-20 opacity-30" />

                    <div className="container mx-auto mb-6 flex items-center justify-between px-3">
                        <span className="text-2xl tracking-wider">
                            <span className="hidden md:inline">
                                {!selectedCase.name.toLowerCase().includes('package') ? (
                                    <span>
                                        Use <span className="font-bold">{selectedCase.name} Key</span>
                                    </span>
                                ) : null}
                            </span>
                        </span>

                        {/* <div className="flex flex-wrap items-center gap-2">
                        <UnlockButton caseId={selectedCase.id} />
                        
                        <div className="mx-2 hidden h-16 w-px bg-white/50 md:inline" />
                        
                        <Button variant="secondary" className="hidden cursor-not-allowed md:inline" playSoundOnClick={false}>
                        CLOSE
                        </Button>
                        </div> */}
                    </div>
                </div>
            </main>
        </AppLayout>
    );
}
