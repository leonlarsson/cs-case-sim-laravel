import { Button } from '@/components/button';
import CaseItem from '@/components/case-item';
import Icons from '@/components/icons';
import SettingsCheckboxes from '@/components/settings-checkboxes';
import AppLayout from '@/layouts/app-layout';
import { formatDecimal } from '@/lib/formatters';
import { statTrakifyName } from '@/lib/utils';
import { ItemGrade } from '@/types';
import { Link } from '@inertiajs/react';

export const metadata = {
    title: 'Global Unbox History | Counter-Strike Case Simulator',
};

type PageProps = {
    unboxes: {
        id: number;
        case_id: number;
        item: {
            name: string;
            image: string;
            rarity: string;
            phase: string;
        };
        is_stat_trak: boolean;
        created_at: string;
        case: {
            name: string;
        };
    }[];
    totalUnboxes: number;
    totalUnboxesCoverts: number;
    totalUnboxesLast24Hours: number;
};

export default ({ unboxes, totalUnboxes, totalUnboxesCoverts, totalUnboxesLast24Hours }: PageProps) => {
    const onlyCoverts = new URLSearchParams(window.location.search).get('onlyCoverts') === 'true';
    const onlyPersonal = new URLSearchParams(window.location.search).get('onlyPersonal') === 'true';

    const totalUnboxed = onlyCoverts ? totalUnboxesCoverts : totalUnboxes;

    // usePoll(5000);

    return (
        <AppLayout>
            <main id="main" className="select-none">
                <div className="relative flex min-h-screen flex-col py-2 backdrop-blur-md">
                    <Button variant="secondary-darker" href="/" className="absolute inset-2 size-fit p-1 max-[650px]:hidden">
                        <Icons.chevronLeft className="size-6" />
                    </Button>

                    <span className="text-center text-3xl font-medium">
                        Last 100 {onlyCoverts ? 'coverts' : 'items'} unboxed by{' '}
                        {onlyPersonal ? <span title="As identified by an anonymous cookie.">you</span> : 'the community'}
                    </span>

                    {/* Total spend */}
                    <span className="text-center">
                        <span>
                            <span className="font-medium tracking-wide">{totalUnboxed.toLocaleString('en')}</span> {onlyCoverts ? 'coverts' : 'items'}{' '}
                            unboxed.{' '}
                            <span className="font-medium tracking-wide" title={`That's $${formatDecimal(totalUnboxed * 2.5)}`}>
                                {formatDecimal(totalUnboxed * 2.35)}€
                            </span>{' '}
                            spent on imaginary keys.
                        </span>

                        {/* <RefreshButton /> */}

                        <br />

                        <span title="All items, regardless of rarity.">
                            <span className="font-medium tracking-wide">{totalUnboxesLast24Hours.toLocaleString('en')}</span> items unboxed in the
                            last 24 hours.
                        </span>
                    </span>

                    <Link href="/" className="mx-auto w-fit text-center text-lg font-medium hover:underline">
                        Open some more!
                    </Link>

                    <hr className="mx-auto mt-5 w-full px-20 opacity-30" />

                    <div className="my-2 flex justify-center">
                        <SettingsCheckboxes />
                    </div>

                    <div className="flex flex-wrap justify-center gap-8 px-2 lg:px-16">
                        {unboxes && unboxes.length === 0 && (
                            <span className="text-center">
                                No items found. Go open some{' '}
                                <Link href="/" className="font-medium hover:underline">
                                    here
                                </Link>
                                !
                            </span>
                        )}

                        {unboxes ? (
                            unboxes.map((unbox) => {
                                const [itemName, skinName] = unbox.item.name.split(' | ');

                                return (
                                    <div
                                        key={unbox.id}
                                        title={`Unboxed on ${new Date(unbox.created_at).toLocaleString('se')} UTC from ${unbox.case.name}\n\nClick to open case.`}
                                    >
                                        <Link href={`/?case=${unbox.case_id}`}>
                                            <CaseItem
                                                itemName={statTrakifyName(itemName, unbox.is_stat_trak)}
                                                skinName={`${skinName} ${unbox.item.phase ? ` (${unbox.item.phase})` : ''}`}
                                                grade={unbox.item.name.includes('★') ? 'Rare Special Item' : (unbox.item.rarity as ItemGrade)}
                                                image={unbox.item.image}
                                            />
                                        </Link>
                                    </div>
                                );
                            })
                        ) : (
                            <span>Error loading items :(</span>
                        )}
                    </div>

                    {onlyPersonal && !onlyCoverts && (
                        <span className="my-5 place-items-end text-center">Older non-covert items are regularly deleted from the database.</span>
                    )}
                </div>
            </main>
        </AppLayout>
    );
};
