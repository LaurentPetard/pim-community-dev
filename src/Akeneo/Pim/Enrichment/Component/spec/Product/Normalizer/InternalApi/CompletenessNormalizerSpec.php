<?php

namespace spec\Akeneo\Pim\Enrichment\Component\Product\Normalizer\InternalApi;

use PhpSpec\ObjectBehavior;
use Akeneo\Channel\Component\Model\ChannelInterface;
use Akeneo\Pim\Enrichment\Component\Product\Model\CompletenessInterface;
use Akeneo\Channel\Component\Model\LocaleInterface;

class CompletenessNormalizerSpec extends ObjectBehavior
{
    function it_supports_completenesses(CompletenessInterface $completeness)
    {
        $this->supportsNormalization($completeness, 'internal_api')->shouldReturn(true);
    }

    function it_normalizes_completeness(
        CompletenessInterface $completeness,
        LocaleInterface $locale,
        ChannelInterface $mobile
    ) {
        $completeness->getRequiredCount()->willReturn(10);
        $completeness->getMissingCount()->willReturn(2);
        $completeness->getRatio()->willReturn(20);
        $completeness->getLocale()->willReturn($locale);
        $completeness->getChannel()->willReturn($mobile);
        $locale->getCode()->willReturn('en_US');
        $mobile->getCode()->willReturn('mobile');

        $this->normalize($completeness, 'internal_api', [])->shouldReturn([
            'required' => 10,
            'missing'  => 2,
            'ratio'    => 20,
            'locale'   => 'en_US',
            'channel'  => 'mobile',
        ]);
    }
}
